<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
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
     * @Route("/administration/commentaires", name="admin_comment")
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $commentRepository->findAll()
        ]);
    }

    /**
     * @Route("/administration/commentaire/{id}/activer", name="admin_comment_active")
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function active(Comment $comment): RedirectResponse
    {
        $comment->setActive(!$comment->getActive());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return $this->redirectToRoute('admin_comment');
    }

    /**
     * @Route("/administration/commentaire/{id}/supprimer", name="admin_comment_delete")
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function delete(Comment $comment): RedirectResponse
    {
        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        $notification = "Le commentaire a bien été supprimé";

        return $this->redirectToRoute('admin_comment', [
            'notification' => $notification
        ]);
    }
}
