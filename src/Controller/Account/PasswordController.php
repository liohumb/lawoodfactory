<?php

namespace App\Controller\Account;

use App\Classes\Mail;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\Password\ChangeType;
use App\Form\Password\ResetType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/votre-compte/modifier-votre-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $notification = null;

        $user = $this->getUser();
        $form = $this->createForm(ChangeType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();

            if ($hasher->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $hasher->hashPassword($user, $new_pwd);

                $user->setPassword($password);

                $this->entityManager->flush();

                $notification = "Votre mot de passe a bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n'est pas le bon.";
            }
        }

        return $this->render('account/password/change.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     * @param Request $request
     * @return Response
     */
    public function reset(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));

            if ($user) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());

                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                $url = $this->generateUrl('update_password', ['token' => $reset_password->getToken()]);
                $mail = new Mail();
                $mail->send(
                    $user->getEmail(),
                    $user->getFirstname() . ' ' . $user->getLastname(),
                    "Réinitialiser votre mot de passe sur L & A WoodFactory",
                    "Bonjour " . $user->getFirstname() . ", <br><br>
                            Vous avez demandé à réinitializer votre mot de passe sur le site L & A WoodFactory. <br><br><br>
                            Merci de bien vouloir cliquer sur le lien suivant pour <br>
                            <a href='https://127.0.0.1:8000". $url ."'>mettre à jour votre mot de passe</a>."
                );

                $this->addFlash('notice', "Vous allez recevoir dans quelques seconde un email avec la procédure pour réinitialiser votre mot de passe.");
            } else {
                $this->addFlash('notice', "Cette adresse email est inconnue.");
            }
        }

        return $this->render('account/password/reset.html.twig');
    }

    /**
     * @Route("/modifier-mon-mot-de-passe/{token}", name="update_password")
     * @param Request $request
     * @param $token
     * @return Response
     */
    public function update(Request $request, $token, UserPasswordHasherInterface $hasher): Response
    {
        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }

        $now = new DateTime();

        if ($now > $reset_password->getCreatedAt()->modify('+ 3 hour')) {
            $this->addFlash('notice', "Votre demande de mot de passe à expiré. Merci de la renouveler.");
            return $this->redirectToRoute('reset_password');
        }

        $form = $this->createForm(ResetType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_pwd = $form->get('new_password')->getData();
            $password = $hasher->hashPassword($reset_password->getUser(), $new_pwd);
            $reset_password->getUser()->setPassword($password);

            $this->entityManager->flush();

            $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');

            return $this->redirectToRoute('login');
        }

        return $this->render('account/password/update.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
