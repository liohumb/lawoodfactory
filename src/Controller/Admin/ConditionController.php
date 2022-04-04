<?php

namespace App\Controller\Admin;

use App\Entity\Condition;
use App\Form\ConditionType;
use App\Repository\ConditionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionController extends AbstractController
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
     * @Route("/administration/conditions", name="admin_condition")
     */
    public function index(ConditionRepository $conditionRepository): Response
    {
        return $this->render('admin/condition/index.html.twig', [
            'conditions' => $conditionRepository->findAll()
        ]);
    }

    /**
     * @Route("/administration/conditions/ajouter", name="admin_condition_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $condition = new Condition();

        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $condition = $form->getData();

            $this->entityManager->persist($condition);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_condition');
        }

        return $this->render('admin/condition/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/conditions/modifier/{id}", name="admin_condition_edit")
     * @param Request $request
     * @param Condition $condition
     * @return Response
     */
    public function edit(Request $request, Condition $condition): Response
    {
        $form = $this->createForm(ConditionType::class, $condition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $condition = $form->getData();

            $this->entityManager->persist($condition);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_condition');
        }

        return $this->render('admin/condition/edit.html.twig', [
            'condition' => $condition,
            'form' => $form->createView()
        ]);
    }
}
