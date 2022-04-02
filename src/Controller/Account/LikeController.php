<?php

namespace App\Controller\Account;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{

    /**
     * @Route("/votre-compte/{id}/produits-aimes", name="account_like")
     * @param $id
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        return $this->render('account/like/index.html.twig', [
            'user' => $user
        ]);
    }
}
