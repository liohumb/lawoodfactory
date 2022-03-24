<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/account/like", name="app_account_like")
     */
    public function index(): Response
    {
        return $this->render('account/like/index.html.twig', [
            'controller_name' => 'LikeController',
        ]);
    }
}
