<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarrierController extends AbstractController
{
    /**
     * @Route("/admin/carrier", name="app_admin_carrier")
     */
    public function index(): Response
    {
        return $this->render('admin/carrier/index.html.twig', [
            'controller_name' => 'CarrierController',
        ]);
    }
}
