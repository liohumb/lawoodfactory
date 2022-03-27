<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @Route("/account/address", name="app_account_address")
     */
    public function index(): Response
    {
        return $this->render('account/address/index.html.twig', [
            'controller_name' => 'AddressController',
        ]);
    }
}
