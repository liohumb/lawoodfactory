<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\User;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
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
     * @Route("/panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('cart_user', ['id' => $this->getUser()->getId()]);
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cart->cart()
        ]);
    }

    /**
     * @Route("/panier/ajout/{id}", name="cart_add")
     */
    public function add($id, Cart $cart): Response
    {
        $cart->add($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/supprimer-quantitee/{id}", name="cart_decrease")
     */
    public function decrease($id, Cart $cart): Response
    {
        $cart->decrease($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/supprimer-produit/{id}", name="cart_delete")
     */
    public function delete($id, Cart $cart): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/panier/supprimer", name="cart_remove")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('product');
    }

    /**
     * @Route("/panier/{id}", name="cart_user")
     */
    public function user($id, Cart $cart): Response
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

        return $this->render('cart/user.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->cart()
        ]);
    }
}
