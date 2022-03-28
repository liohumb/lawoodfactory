<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Form\CarrierType;
use App\Repository\CarrierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarrierController extends AbstractController
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
     * @Route("/administration/transporteurs", name="admin_carrier")
     * @param CarrierRepository $carrierRepository
     * @return Response
     */
    public function index(CarrierRepository $carrierRepository): Response
    {
        return $this->render('admin/carrier/index.html.twig', [
            'carriers' => $carrierRepository->findAll()
        ]);
    }

    /**
     * @Route("/administration/transporteurs/ajouter", name="admin_carrier_add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Request $request): Response
    {
        $carrier = new Carrier();

        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrier = $form->getData();

            $this->entityManager->persist($carrier);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_carrier');
        }

        return $this->render('admin/carrier/add.html.twig', [
            'carrier' => $carrier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/transporteurs/editer/{id}", name="admin_carrier_edit")
     * @param Request $request
     * @param Carrier $carrier
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, Carrier $carrier): Response
    {
        $form = $this->createForm(CarrierType::class, $carrier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carrier = $form->getData();

            $this->entityManager->persist($carrier);
            $this->entityManager->flush();

            return $this->redirectToRoute('admin_carrier');
        }

        return $this->render('admin/carrier/edit.html.twig', [
            'carrier' => $carrier,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/administration/transporteurs/supprimer/{id}", name="admin_carrier_delete")
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $carrier = $this->entityManager->getRepository(Carrier::class)->findOneById($id);

        if ($carrier) {
            $this->entityManager->remove($carrier);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('admin_carrier');
    }
}
