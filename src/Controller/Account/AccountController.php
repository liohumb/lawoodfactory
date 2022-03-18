<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account/account", name="app_account_account")
     */
    public function index(): Response
    {
        return $this->render('account/account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }
}
