<?php

namespace App\Controller;

use App\Repository\ConditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionController extends AbstractController
{
    /**
     * @Route("/conditions", name="condition")
     */
    public function index(ConditionRepository $conditionRepository): Response
    {
        return $this->render('condition/index.html.twig', [
            'conditions' => $conditionRepository->findAll()
        ]);
    }
}
