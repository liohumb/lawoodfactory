<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConditionController extends AbstractController
{
    /**
     * @Route("/admin/condition", name="app_admin_condition")
     */
    public function index(): Response
    {
        return $this->render('admin/condition/index.html.twig', [
            'controller_name' => 'ConditionController',
        ]);
    }
}
