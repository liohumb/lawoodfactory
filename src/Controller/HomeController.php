<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Form\ContactType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProductRepository $productRepository
     * @param Request $request
     * @return Response
     */
    public function index(ProductRepository $productRepository, Request $request): Response
    {
        $notification = null;

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification = "Merci de nous avoir contacté. Nous vous répondrons dans les meilleurs délais.";

            $mail = new Mail();
            $mail->send(
                'contact@lawoodfactory.fr',
                'L&A WoodFactory',
                'Vous avez un nouveau message • L&A WoodFactory',
                "Bonjour Patron ! <br><br>
                        J'ai l'immense honneur de vous annoncer que vous venez de recevoir un nouveau message par le biais du formulaire de contact. <br><br>
                        C'est un message de <b>" . $form->getData()['name'] . "</b>. <br><br>
                        Voici ce qu'il contient : <br>
                        “<i>" . $form->getData()['content'] . "</i>” <br><br>
                        Voici l'adresse email pour la réponse : <br>
                        <b>" . $form->getData()['email'] ."</b><br><br><br>
                        Je me permet de vous rappeler que si vous souhaitez répondre à ce message, un copier-coller du message de " . $form->getData()['name'] . " devra être fait par vous dans la réponse. <br><br>
                        Il ne me reste plus qu'à vous souhaitez une bonne journée ! <br>
                        BISOU BISOU !!"
            );
        }

        return $this->render('home/index.html.twig', [
            'productBest' => $productRepository->findByIsBest(1),
            'productNew' =>$productRepository->findBy([], ['createdAt' => 'desc'], 4),
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
