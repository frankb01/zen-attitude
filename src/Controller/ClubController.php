<?php

namespace App\Controller;

use App\Repository\TimeSlotRepository;
use App\Repository\MembershipRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClubController extends AbstractController
{
    /**
     * @Route("/club", name="club_index")
     */
    public function index(TimeSlotRepository $repo, MembershipRepository $membershipRepo)
    {
        $timeSlots = $repo->findAll();
        $memberships = $membershipRepo->findAll();

        return $this->render('club/index.html.twig', [
            'time_slots' => $timeSlots,
            'memberships' => $memberships,
        ]);
    }
}
