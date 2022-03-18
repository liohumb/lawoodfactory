<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordController extends AbstractController
{
    /**
     * @Route("/account/password", name="app_account_password")
     */
    public function index(): Response
    {
        return $this->render('account/password/index.html.twig', [
            'controller_name' => 'PasswordController',
        ]);
    }
}
