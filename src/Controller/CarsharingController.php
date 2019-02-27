<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Entity\Carsharing;
use App\Repository\CarsharingRepository;
use App\Form\CarsharingType;

/**
 * @Route("/membre/covoiturage", name="carsharing_")
 */
class CarsharingController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(CarsharingRepository $carsharingRepo)
    {
        $user = $this->getUser();

        $carsharings = $carsharingRepo->findAllExceptDriverEqualUser($user);

        foreach ($carsharings as $key => $carsharing) {

            // on l'enlève du tableau carsharings le carsharing pour lequel l'user est deja passager
            if ($carsharing->getPassengers()->contains($user)) {
                unset($carsharings[$key]);
            }

            // on enlève du tableau carsharings le carsharing qui n'ont plus de place disponible
            if ($carsharing->getPassengers()->count() >= $carsharing->getSeatNumber()) {
                unset($carsharings[$key]);
            }
        }
        
        return $this->render('carsharing/index.html.twig', [
            'carsharings' => $carsharings,
        ]);
    }

    /**
     * @Route("/ajout", name="new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $em)
    {
        $carsharing = new Carsharing();

        $form = $this->createForm(CarsharingType::class, $carsharing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $carsharing->setDriver($user);

            $em->persist($carsharing);
            $em->flush();
            $this->addFlash('success', 'Le co-voiturage a bien été enregistré');

            return $this->redirectToRoute('user_dashboard');
        }

        return $this->render('carsharing/new.html.twig', [
            'carsharing' => $carsharing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/prendre/{id}", name="take", methods={"GET"})
     */
    public function take(Carsharing $carsharing, EntityManagerInterface $em)
    {
        $user = $this->getUser();

        // On ajoute l'user comme passager uiquement si il reste des place disponible
        if ( $carsharing->getPassengers()->count() < $carsharing->getSeatNumber() ) {

            $carsharing->addPassenger($user);

            $em->persist($carsharing);
            $em->flush();

            $this->addFlash('success', 'Félicitation ! Vous voila inscrit au co-voiturage pour le stage de ' . $carsharing->getStageApi()->getAnimator());

            return $this->redirectToRoute('user_dashboard');
        }

        $this->addFlash('danger', 'Ce co-voiturage n\'est plus disponible');

        return $this->redirectToRoute('carsharing_index');
    }

    /**
     * @Route("/tous-les-covoiturages", name="show-all", methods={"GET"})
     */
    public function showAll(CarsharingRepository $carsharingRepo)
    {
        $carsharings = $carsharingRepo->findAll();

        return $this->render('carsharing/show-all.html.twig', [
            'carsharings' => $carsharings
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Carsharing $carsharing)
    {
        return $this->render('carsharing/show.html.twig', [
            'carsharing' => $carsharing
        ]);
    }

    

    /**
     * @Route("/modification", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request)
    {

    }

    /**
     * @Route("/suppression/{id}", name="delete", methods={"GET","DELETE"})
     */
    public function delete(Carsharing $carsharing, EntityManagerInterface $em, Request $request)
    {
        $page = $request->get("page");

        $em->remove($carsharing);
        $em->flush();

        $this->addFlash('success', 'le co-voiture à bien été supprimé');

        if ($page == "admin") {
            return $this->redirectToRoute('carsharing_show-all');
        } elseif ($page == "profil") {
            return $this->redirectToRoute('user_dashboard');
        }
    }

    /**
     * @Route("/suppression/{id}/place", name="remove-place", methods={"GET","DELETE"})
     */
    public function removePlace(Carsharing $carsharing, EntityManagerInterface $em, Request $request)
    {
        $user = $this->getUser();
        $user->removePassengerCarsharing($carsharing);

        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Vous n\'êtes plus inscrit sur le co-voiturage pour le ' . $carsharing->getStageApi());

        return $this->redirectToRoute('user_dashboard');
    }
}
