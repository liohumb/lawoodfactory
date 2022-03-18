<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/inscription", name="register")
     * @param Request $request
     * @param UserPasswordHasherInterface $hasher
     * @return Response
     * @throws Exception
     */
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $user->setToken($this->token());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $url = $this->generateUrl('register_confirm', ['token' => $user->getToken()]);
            $mail = new Mail();
            $mail->send(
                $user->getEmail(),
                $user->getFirstname() . ' ' . $user->getLastname(),
                "Confirmation d'em@il • L & A WoddFactory",
                "Bien le bonjour " . $user->getFirstname() . ",<br><br>
                        Avant tout, nous vous remercions pour votre inscription sur le site <b>L & A WoodFactory</b>. <br><br><br>
                        Il reste encore une petite étape pour finaliser votre inscription. <br>
                        Afin de confirmer votre adresse em@il et de pouvoir commander sur L & A WoodFactory <br>
                        <a href='https://127.0.0.1:8000" . $url . "'>merci de cliquer ici</a>. <br><br><br>
                        Si vous rencontrez des difficultés à vous connecter n'hésitez pas à <a href='https://lawoodfactory.fr/#contat'>nous contacter</a>."
            );

            return $this->redirectToRoute('register_success');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/inscription/inscription-reussie", name="register_success")
     * @return Response
     */
    public function success(): Response
    {
        return $this->render('register/success.html.twig');
    }

    /**
     * @Route("/inscription/confirmer-mon-email/{token}", name="register_confirm")
     * @param $token
     * @return RedirectResponse
     */
    public function confirm($token): RedirectResponse
    {
        $user = $this->userRepository->findOneBy(['token' => $token]);

        if ($user) {
            $user->setToken(null);
            $user->setActive(1);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->redirectToRoute('register');
        }
    }

    /**
     * @throws Exception
     */
    private function token(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
