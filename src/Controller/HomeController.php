<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'productBest' => $productRepository->findByIsBest(1),
            'productNew' =>$productRepository->findBy([], ['createdAt' => 'desc'], 4)
        ]);
    }
}
