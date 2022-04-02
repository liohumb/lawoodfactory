<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SuccessController extends AbstractController
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
     * @Route("/votre-commande/{id}/merci/{stripe}", name="order_success")
     * @param $id
     * @param $stripe
     * @param Cart $cart
     * @return Response
     */
    public function index($id, $stripe, Cart $cart): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripe($stripe);

        if (!$user) {
            return $this->redirectToRoute('cart');
        }

        if (!$order) {
            return $this->redirectToRoute('home');
        }

        if (!$order->getIsPaid()) {
            $cart->remove();
            $order->setIsPaid(1);

            $this->entityManager->flush();
        }

        return $this->render('order/success/index.html.twig', [
            'order' => $order
        ]);
    }
}
