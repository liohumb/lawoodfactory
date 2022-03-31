<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\User;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
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
     * @Route("/votre-commande/{id}", name="order", methods={"POST"})
     */
    public function index($id, Cart $cart, Request $request): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        if (!$user) {
            return $this->redirectToRoute('cart');
        }

        if (!$user->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add', ['id' => $id]);
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();

            $deliveryContent  = $delivery->getFirstname() . ' ' . $delivery->getLastname() . '<br/>';
            if ($delivery->getCompany()) {
                $deliveryContent .= $delivery->getCompany() . '<br>';
            }
            $deliveryContent .= $delivery->getAddress() . '<br>';
            $deliveryContent .= $delivery->getPostcode() . ' ' . $delivery->getCity() . '<br>';
            $deliveryContent .= $delivery->getPhone();

            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($deliveryContent);
            $order->setIsPaid(0);

            $this->entityManager->persist($order);

            foreach ($cart->cart() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getTitle());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->entityManager->persist($orderDetails);
            }

            $this->entityManager->flush();

            return $this->render('order/index.html.twig', [
                'cart' => $cart->cart(),
                'carrier' => $carriers,
                'delivery' => $delivery
            ]);
        }

        return $this->redirectToRoute('cart');

    }
}
