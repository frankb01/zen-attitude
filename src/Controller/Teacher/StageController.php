<?php

namespace App\Controller\Teacher;

use App\Entity\StageApi;
use App\Entity\StageClub;
use App\Form\StageClubType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class StageController extends AbstractController
{
    /**
     * @Route("/professeur/stage/ajout", name="teacher_stage_new")
     */
    public function new(Request $request)
    {
        $newStage = new StageClub();

        $form = $this->createForm(StageClubType::class, $newStage);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $stage = $form->getData();

            $file = $stage->getPoster();
            if(!is_null($stage->getPoster())) {
            
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('media_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                dump($e);
                }
                $stage->setPoster($fileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stage);
            $entityManager->flush();
            $this->addFlash('success', 'Nouveau stage interne ajouté');

            return $this->redirectToRoute('teacher_index');

        }

        return $this->render('teacher/stage_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/professeur/stage/{id}/modification", name="teacher_stage_edit")
     */
    public function edit(Request $request, StageClub $stageClub)
    {
        $oldPoster = $stageClub->getPoster();
        if(!empty($oldPoster)) {
            $stageClub->setPoster(
                new File($this->getParameter('media_directory').'/'.$oldPoster)
            );
        }

        $form = $this->createForm(StageClubType::class, $stageClub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!is_null($stageClub->getPoster())){
                $file = $stageClub->getPoster();
            
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('media_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    dump($e);
                }
                
                $stageClub->setPoster($fileName);

                if(!empty($oldPoster)){
                    //fonction native a php qui supprime des fichiers
                    unlink(
                        $this->getParameter('media_directory') .'/'.$oldPoster
                    );
                }
            } else {
                $stageClub->setPoster($oldPoster);
            }
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le stage a été modifié');
            return $this->redirectToRoute('teacher_index');
        }
        return $this->render('teacher/stage_edit.html.twig', [
            'stage' => $stageClub,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/professeur/stage/{id}/suppression", name="teacher_stage_delete")
     */
    public function delete(Request $request, StageClub $stageClub)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($stageClub);
        $entityManager->flush();

        // je récupère le nom de mon fichier en bdd
        $fileName = $stageClub->getPoster();
        // j'efface le fichier uploadé dans public/uploads/media
        unlink($this->getParameter('media_directory') .'/'.$fileName);

        $this->addFlash('success', 'Le stage à bien été supprimé');
        return $this->redirectToRoute('teacher_index');
    }

    /**
     * @Route("/professeur/stageapi/{id}/{animator}/{date}/valider", name="teacher_stage_api_validate")
     */
    public function validateApiStage(Request $request, $id, $animator, $date )
    {
        $stageApiValidation = new StageApi();
        $stageApiValidation->setIdApi($id);
        // TODO animator - date
        $stageApiValidation->setAnimator($animator);
        $stageApiValidation->setDate($date);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stageApiValidation);
        $entityManager->flush();
        $this->addFlash('success', 'Le stage a bien été validé');
        return $this->redirectToRoute('teacher_index', [ 'teacherToggleInfo' => 'stages_extern' ]);
    }

    /**
     * @Route("/professeur/stageapi/{id}/supprimer", name="teacher_stage_api_unvalidate")
     */
    public function unvalidateApiStage(Request $request, $id) {

        $stageApi = $this->getDoctrine()->getRepository(StageApi::class)->findOneBy(['id_api' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($stageApi);
        $entityManager->flush();
        $this->addFlash('success', 'Le stage a bien été retiré des stages conseillés');
        return $this->redirectToRoute('teacher_index', [ 'teacherToggleInfo' => 'stages_extern' ]);
    }


    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}