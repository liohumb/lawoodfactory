<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Form\ServiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(Request $request): Response
    {
        $notification = null;

        $form = $this->createForm(ServiceType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notification = "Merci de nous avoir contacté. <br>Nous vous répondrons dans les meilleurs délais.";

            $mail = new Mail();
            $mail->send(
                'contact@lawoodfactory.fr',
                'L&A WoodFactory',
                'Vous avez une nouvelle demande de devis • L&A WoodFactory',
                "Bonjour Patron ! <br><br>
                        J'ai l'immense honneur de vous annoncer que vous venez de recevoir une nouvelle demande de devis par le biais du formulaire de contact. <br><br>
                        C'est un message de <b>" . $form->getData()['name'] . "</b> de <b>" . $form->getData()['city'] . "</b>. <br><br>
                        Voici la demande : <br>
                        “<i>" . $form->getData()['content'] . "</i>” <br><br>
                        Voici le numéro de téléphone de  " . $form->getData()['name'] . ": <br>
                        <b>" . $form->getData()['phone'] ."</b><br><br>
                        Et voici son adresse email pour la réponse : <br>
                        <b>" . $form->getData()['email'] ."</b><br><br><br>
                        Je me permet de vous rappeler que si vous souhaitez répondre à ce message, un copier-coller du message de " . $form->getData()['name'] . " devra être fait par vous dans la réponse. <br><br>
                        En espérant que cela vous m'enneras vers un nouveau boulot, je vous souhaite une très bonne journée !<br>
                        PLEIN DE POUTOU !!"
            );
        }

        return $this->render('service/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
