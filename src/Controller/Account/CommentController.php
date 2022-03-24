<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/account/comment", name="app_account_comment")
     */
    public function index(): Response
    {
        return $this->render('account/comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }
}
