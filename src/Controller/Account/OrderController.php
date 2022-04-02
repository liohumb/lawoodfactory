<?php

namespace App\Controller\Account;

use App\Entity\Order;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @Route("/votre-compte/{id}/commandes", name="account_order")
     * @param $id
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        return $this->render('account/order/index.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/votre-compte/{id}/commandes/{reference}", name="account_order_show")
     * @param $id
     * @param $reference
     * @param UserRepository $userRepository
     * @return RedirectResponse|Response
     */
    public function show($id, $reference, UserRepository $userRepository)
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order', ['id' => $user->getId()]);
        }

        return $this->render('account/order/show.html.twig', [
            'order' => $order
        ]);
    }
}
