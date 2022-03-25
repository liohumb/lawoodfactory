<?php

namespace App\Controller;

use App\Classes\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
        dd($cart->get());
        return $this->render('cart/index.html.twig');
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
     * @Route("/panier/supprimer", name="cart_remove")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('product');
    }
}
