<?php

namespace App\Controller\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order/order", name="app_order_order")
     */
    public function index(): Response
    {
        return $this->render('order/order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
