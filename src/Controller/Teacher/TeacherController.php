<?php

namespace App\Controller\Teacher;

use App\Entity\User;
use App\Entity\StageApi;
use App\Entity\StageClub;
use App\Form\TeacherCommentType;
use App\Form\TeacherEditMemberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TeacherController extends AbstractController
{
    /**
     * @Route("/professeur/classe", name="teacher_index")
     */
    public function index(Request $request)
    {
        $user = $this->getUser();
        $usersList = $this->getDoctrine()->getRepository(User::class)->findAll();
        $stagesClubList = $this->getDoctrine()->getRepository(StageClub::class)->findAll();
        $stageApiValidate = $this->getDoctrine()->getRepository(StageApi::class)->findAll();

        // info pour le toggle stages de la page prof
        $teacherToggleInfo = $request->get('teacherToggleInfo');

        $suggestedApiStage = [];

        foreach ( $stageApiValidate as $currentId ) {
            $suggestedApiStage[] = $currentId->getIdApi();
        }

        return $this->render('teacher/index.html.twig', [
            'user' => $user,
            'usersList' => $usersList,
            'stagesClubList' => $stagesClubList,
            'suggestedApiStage' => $suggestedApiStage,
            'teacherToggleInfo' => $teacherToggleInfo
        ]);
    }

    /**
     * @Route("/professeur/membre/{id}/fiche", name="teacher_member_show")
     */
    public function showMember(User $user, Request $request)
    {

        return $this->render('teacher/member_show.html.twig',[
            'member' => $user
        ]);
    }

    /**
     * @Route("/professeur/membre/{id}/fiche/modification", name="teacher_member_edit")
     */
    public function edit(Request $request, User $user)
    {
        $form = $this->createForm(TeacherEditMemberType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->addFlash('success', 'Fiche de progression mise à jour');
            return $this->render('teacher/member_show.html.twig',[
                'member' => $user
            ]);
            
        }

        return $this->render('teacher/member_edit.html.twig',[
            'member' => $user,
            'form' => $form->createView()
        ]);
    }
}