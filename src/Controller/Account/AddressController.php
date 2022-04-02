<?php

namespace App\Controller\Account;

use App\Classes\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
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
     * @Route("/votre-compte/{id}/adresses", name="account_address")
     * @param $id
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        return $this->render('account/address/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/votre-compte/{id}/adresses/ajouter", name="account_address_add")
     * @param $id
     * @param UserRepository $userRepository
     * @param Request $request
     * @param Cart $cart
     * @return Response
     */
    public function add($id, UserRepository $userRepository, Request $request, Cart $cart): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            if ($cart->get()) {
                return $this->redirectToRoute('cart_user', ['id' => $id]);
            } else {
                return $this->redirectToRoute('account_address', ['id' => $id]);
            }
        }

        return $this->render('account/address/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/votre-compte/{id}/adresses/modifier/{addressId}", name="account_address_edit")
     * @param $id
     * @param UserRepository $userRepository
     * @param $addressId
     * @param Request $request
     * @return Response
     */
    public function edit($id, UserRepository $userRepository, $addressId, Request $request): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $address = $this->entityManager->getRepository(Address::class)->findOneById($addressId);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address', ['id' => $id]);
        }

        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('account_address', ['id' => $id]);
        }

        return $this->render('account/address/edit.html.twig', [
            'form' => $form->createView(),
            'address' => $address
        ]);
    }

    /**
     * @Route("/votre-compte/{id}/adresses/suprimer/{addressId}", name="account_address_delete")
     * @param $id
     * @param UserRepository $userRepository
     * @param $addressId
     * @return Response
     */
    public function delete($id, UserRepository $userRepository, $addressId): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        if ($user !== $this->getUser()) {
            return $this->redirectToRoute('account');
        }

        $address = $this->entityManager->getRepository(Address::class)->findOneById($addressId);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('account_address', ['id' => $id]);
    }
}