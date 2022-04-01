<?php

namespace App\Controller\Order;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
{
    /**
     * @Route("/order/success", name="app_order_success")
     */
    public function index(): Response
    {
        return $this->render('order/success/index.html.twig', [
            'controller_name' => 'SuccessController',
        ]);
    }
}
