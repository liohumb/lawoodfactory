<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\SearchUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
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
     * @Route("/administration/utilisateur", name="admin_user")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['createdAt' => 'desc']);

        $form = $this->createForm(SearchUserType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $users = $this->entityManager->getRepository(User::class)->search($form->get('mots')->getData());
        }

        return $this->render('admin/user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/utilisateur/{id}", name="admin_user_show")
     * @param $id
     * @return Response
     */
    public function show($id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneById($id);

        if (!$user) {
            return $this->redirectToRoute('admin_user');
        }

        return $this->render('admin/user/show.html.twig', [
            'user' => $user
        ]);
    }
}
