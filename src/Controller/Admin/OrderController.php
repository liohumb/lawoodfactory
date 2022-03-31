<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/admin/order", name="app_admin_order")
     */
    public function index(): Response
    {
        return $this->render('admin/order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
