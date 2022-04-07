<?php

namespace App\Controller\Admin;

use App\Classes\Mail;
use App\Entity\Order;
use App\Form\StateType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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
     * @Route("/administration/commandes", name="admin_order")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $dataPaid = $this->entityManager->getRepository(Order::class)->findby(['state' => 1],['createdAt' => 'desc']);
        $dataBuild = $this->entityManager->getRepository(Order::class)->findby(['state' => 2],['createdAt' => 'desc']);
        $dataDelivery = $this->entityManager->getRepository(Order::class)->findby(['state' => 3],['createdAt' => 'desc']);
        $dataComplete = $this->entityManager->getRepository(Order::class)->findby(['state' => 4],['createdAt' => 'desc']);

        $orderPaid = $paginator->paginate($dataPaid, $request->query->getInt('page', 1), 4);
        $orderBuild = $paginator->paginate($dataBuild, $request->query->getInt('page', 1), 4);
        $orderDelivery = $paginator->paginate($dataDelivery, $request->query->getInt('page', 1), 4);
        $orderComplete = $paginator->paginate($dataComplete, $request->query->getInt('page', 1), 4);

        return $this->render('admin/order/index.html.twig', [
            'orderPaid' => $orderPaid,
            'orderBuild' => $orderBuild,
            'orderDelivery' => $orderDelivery,
            'orderComplete' => $orderComplete
        ]);
    }

    /**
     * @Route("/administration/commandes/livree", name="admin_order_delivery")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function delivery(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $this->entityManager->getRepository(Order::class)->findBy(['state' => 3], ['createdAt' => 'desc']);
        $orders = $paginator->paginate($data, $request->query->getInt('page', 1), 9);

        return $this->render('admin/order/delivery.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/administration/commandes/complete", name="admin_order_complete")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function complete(Request $request, PaginatorInterface $paginator): Response
    {
        $data = $this->entityManager->getRepository(Order::class)->findBy(['state' => 4], ['createdAt' => 'desc']);
        $orders = $paginator->paginate($data, $request->query->getInt('page', 1), 9);

        return $this->render('admin/order/complete.html.twig', [
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/administration/commandes/{reference}", name="admin_order_show")
     * @param $reference
     * @param Request $request
     * @return Response
     */
    public function show($reference, Request $request): Response
    {
        $notification = null;

        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
            return $this->redirectToRoute('admin_order');
        }

        $form = $this->createForm(StateType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $notification = "Le statut de la commande a bien été mis à jour.";

            if ($form->get('state')->getData() == '2' ) {
                $mail = new Mail();
                $mail->send(
                    $order->getUser()->getEmail(),
                    $order->getUser()->getFirstname() . ' ' . $order->getUser()->getLastname(),
                    "Votre commande L&A WoodFactory est en fabrication",
                    "Bonjour " . $order->getUser()->getFirstname() . ", <br><br>
                            Nous sommes ravie de vous annoncer que votre commande n°" . $order->getReference() . " est en cours de fabrication. <br><br>
                            Pour suivre l'avancement de votre commande n'hésitez à vous rendre <a href='https://lawoodfactory.fr/votre-compte/" . $order->getUser()->getId() ."/commandes/" . $order->getReference() . "' style='color: gray'>dans votre compte L&A WoodFactory</a>."
                );
            }

            if ($form->get('state')->getData() == '3' ) {
                $mail = new Mail();
                $mail->send(
                    $order->getUser()->getEmail(),
                    $order->getUser()->getFirstname() . ' ' . $order->getUser()->getLastname(),
                    "Votre commande L&A WoodFactory est en cours de livraison",
                    "Bonjour " . $order->getUser()->getFirstname() . ", <br><br>
                            Nous sommes ravie de vous annoncer que votre commande n°" . $order->getReference() . " a été remis au transporteur " . $order->getCarrierName() .". <br><br>
                            Un email avec les informations de suivi vous sera transmis dans les plus bref délais. <br><br><br>
                            Un très gand merci pour votre commande et à bientôt sur <a href='https://lawoodfactory.fr' style='color: gray'>L&AWoodFactory.fr</a> !"
                );
            }
        }

        return $this->render('admin/order/show.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
