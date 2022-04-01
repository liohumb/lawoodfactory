<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/votre-commande/{id}/create-session/{reference}", name="order_stripe")
     * @param $id
     * @param $reference
     * @param Cart $cart
     * @return Response
     * @throws ApiErrorException
     */
    public function index($id, $reference, Cart $cart): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$user) {
            return $this->redirectToRoute('cart');
        }

        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }

        $productStripe = [];
        $YOUR_DOMAIN = 'https://127.0.0.1:8000';

        foreach ($order->getOrderDetails()->getValues() as $product) {
            $productObject = $this->entityManager->getRepository(Product::class)->findOneByTitle($product->getProduct());
            $productStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice() * 100,
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$YOUR_DOMAIN . "/uploads/" . $productObject->getIllustrations()[0]->getTitle()]
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }

        $productStripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice() * 100,
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN]
                ],
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51KjJP6ILc6D6W35zfdxgP1f9suXT9AfXRmGbCE1GBHt8ZcRfrJkvjOi6WATFxgIkqQMiyVd0orhupxvOUuXeGcQU00dfYeOWWT');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getUserIdentifier(),
            'line_items' => [
                $productStripe
            ],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/votre-commande/' . $user->getId() . '/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/votre-commande/' . $user->getId() . '/erreur/{CHECKOUT_SESSION_ID}',
        ]);

        $order->setStripe($checkout_session->id);

        $this->entityManager->flush();

        return new JsonResponse(['id' => $checkout_session->id]);
    }
}
