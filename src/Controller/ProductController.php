<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Product;
use App\Form\CommentType;
use App\Repository\LikeRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/produits", name="product")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findBy(['active' => true], ['createdAt' => 'desc'])
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product_show")
     * @param $slug
     * @param Request $request
     * @return Response
     */
    public function show($slug, Request $request): Response
    {
        $notification = null;

        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$product) {
            return $this->redirectToRoute('product');
        }

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setActive(true);
            $comment->setProduct($product);
            $comment->setUser($this->getUser());

            $parentId = $form->get('parentid')->getData();

            if ($parentId !== null) {
                $parent = $this->entityManager->getRepository(Comment::class)->find($parentId);
            }

            $comment->setParent($parent ?? null);

            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            $notification = "Votre commentaire a bien été publié";
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'comments' => $comment,
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }

    /**
     * @Route("/produit/aimer/{slug}", name="product_like")
     * @param Product $product
     * @param LikeRepository $likeRepository
     * @return Response
     */
    public function like(Product $product, LikeRepository $likeRepository): Response
    {
        $user = $this->getUser();

        if (!$user) return $this->json([
            'code' => 403,
            'message' => "Unauthorized"
        ], 403);

        if ($product->isLikedByUser($user)) {
            $like = $likeRepository->findOneBy(['product' => $product, 'user' => $user]);

            $this->entityManager->remove($like);
            $this->entityManager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepository->count(['product' => $product])
            ], 200);
        }

        $like = new Like();
        $like->setProduct($product);
        $like->setUser($user);

        $this->entityManager->persist($like);
        $this->entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likeRepository->count(['product' => $product])
        ], 200);
    }
}
