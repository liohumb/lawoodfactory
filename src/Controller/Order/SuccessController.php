<?php

namespace App\Controller\Order;

use App\Classes\Cart;
use App\Classes\Mail;
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

        if ($order->getState() == 0) {
            $cart->remove();
            $order->setState(1);

            $this->entityManager->flush();

            $mail = new Mail();
            $mail->send(
                $order->getUser()->getEmail(),
                $order->getUser()->getFirstname(),
                'Votre commande L&A WoodFactory est bien validée',
                "Bien le bonjour " . $user->getFirstname() . ",<br><br>
                        Avant tout, nous vous remercions pour votre commande n°" . $order->getReference() . ".<br><br><br>
                        Nous allons sans plus tarder commencer la fabrication de votre commande. <br>
                        Retrouvez l'avancement de votre commande <a href='https://lawoodfactory.fr/votre-compte/" . $user->getId() . "/commandes/" . $order->getReference() ."' style='color: grey'>dans votre compte L&A WoodFactory</a>."
            );

            $mailAdmin = new Mail();
            $mailAdmin->send(
                'contact@lawoodfactory.fr',
                'L&A WoodFactory',
                'Nouvelle commande sur L&A WoodFactory',
                "Bonne nouvelle Patron ! <br><br>
                        Vous avez une nouvelle commande sur L&AWoodFactory. <br>
                        La commande n°" . $order->getReference() . " de " . $user->getFirstname() . " " . $user->getLastname() . " n'attend plus que vous. <br>
                        Tout les détails sont dans <a href='https://lawoodfactory.fr/administration/commandes/" . $order->getReference() . "' style='color: grey'>votre administration</a>. <br><br>
                        Félicitation et au boulot !!"
            );
        }

        return $this->render('order/success/index.html.twig', [
            'order' => $order
        ]);
    }
}
