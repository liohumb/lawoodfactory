<?php

namespace App\Controller\Admin;

use App\Entity\Illustration;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
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
     * @Route("/administration/produits", name="admin_product")
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/administration/produit/ajouter", name="admin_product_add")
     */
    public function add(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $illustrations = $form->get('illustration')->getData();

            foreach ($illustrations as $illustration) {
                $file = md5(uniqid()) . '.' . $illustration->guessExtension();
                $illustration->move($this->getParameter('illustration_directory'), $file);

                $ill = new Illustration();
                $ill->setTitle($file);

                $product->addIllustration($ill);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_product');
        }
        return $this->render('admin/product/add.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/produit/editer/{id}", name="admin_product_edit")
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $illustrations = $form->get('illustration')->getData();

            foreach ($illustrations as $illustration) {
                $file = md5(uniqid()) . '.' . $illustration->guessExtension();
                $illustration->move($this->getParameter('illustration_directory'), $file);

                $ill = new Illustration();
                $ill->setTitle($file);

                $product->addIllustration($ill);
            }

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_product');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/produit/supprimer/{id}", name="admin_product_delete")
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneById($id);

        if ($product) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_product');
    }

    /**
     * @Route("/administration/product/supprimer-illustration/{id}", name="admin_illustration_delete")
     */
    public function deleteIllustration(Illustration $illustration, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete'.$illustration->getId(), $data['_token'])) {
            $title = $illustration->getTitle();
            unlink($this->getParameter('illustration_directory').'/'.$title);

            $this->entityManager->remove($illustration);
            $this->entityManager->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
