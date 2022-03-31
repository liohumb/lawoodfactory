<?php

namespace App\Controller\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/order/stripe", name="app_order_stripe")
     */
    public function index(): Response
    {
        return $this->render('order/stripe/index.html.twig', [
            'controller_name' => 'StripeController',
        ]);
    }
}
