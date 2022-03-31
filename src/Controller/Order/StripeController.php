<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/votre-commande/create-session", name="order_stripe")
     * @param Cart $cart
     * @return Response
     * @throws ApiErrorException
     */
    public function index(Cart $cart): Response
    {
        $productStripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';

        foreach ($cart->cart() as $product) {
            $productStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice() * 100,
                    'product_data' => [
                        'name' => $product['product']->getTitle(),
                        'images' => [$YOUR_DOMAIN . "/uploads/" . $product['product']->getIllustrations()[0]->getTitle()]
                    ],
                ],
                'quantity' =>  $product['quantity'],
            ];
        }

        Stripe::setApiKey('sk_test_51KjJP6ILc6D6W35zfdxgP1f9suXT9AfXRmGbCE1GBHt8ZcRfrJkvjOi6WATFxgIkqQMiyVd0orhupxvOUuXeGcQU00dfYeOWWT');

        $checkout_session = Session::create([
            'line_items' => [
                $productStripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $response = new JsonResponse(['id' => $checkout_session->id]);

        return $response;
    }
}
