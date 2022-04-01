<?php

namespace App\Controller\Order;

use App\Entity\Order;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CancelController extends AbstractController
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
     * @Route("/votre-commande/{id}/erreur/{stripe}", name="order_cancel")
     */
    public function index($id, $stripe): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripe($stripe);

        if (!$user) {
            return $this->redirectToRoute('cart');
        }

        if (!$order) {
            return $this->redirectToRoute('home');
        }

        return $this->render('order/cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
