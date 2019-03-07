<?php

namespace App\Controller;

use App\Entity\Membership;
use App\Form\MembershipType;
use App\Repository\MembershipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tarifs")
 */
class MembershipController extends AbstractController
{
    /**
     * @Route("/", name="membership_index", methods={"GET"})
     */
    public function index(MembershipRepository $membershipRepository): Response
    {
        return $this->render('membership/index.html.twig', [
            'memberships' => $membershipRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ajout", name="membership_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $membership = new Membership();
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membership);
            $entityManager->flush();

            return $this->redirectToRoute('membership_index');
        }

        return $this->render('membership/new.html.twig', [
            'membership' => $membership,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/modification/{id}", name="membership_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Membership $membership): Response
    {
        $form = $this->createForm(MembershipType::class, $membership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membership_index', [
                'id' => $membership->getId(),
            ]);
        }

        return $this->render('membership/edit.html.twig', [
            'membership' => $membership,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/suppression/{id}", name="membership_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, Membership $membership)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($membership);
        $entityManager->flush();
        $this->addFlash('success', 'Tarif cotisation supprimé.');

        return $this->redirectToRoute('membership_index');
    }
}
