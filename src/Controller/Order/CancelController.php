<?php

namespace App\Controller\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancelController extends AbstractController
{
    /**
     * @Route("/order/cancel", name="app_order_cancel")
     */
    public function index(): Response
    {
        return $this->render('order/cancel/index.html.twig', [
            'controller_name' => 'CancelController',
        ]);
    }
}
