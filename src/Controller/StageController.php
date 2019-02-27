<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

use App\Entity\StageApi;
use App\Entity\StageClub;
use Symfony\Component\HttpFoundation\JsonResponse;

class StageController extends AbstractController
{
    /**
     * @Route("/stages", name="stage_index", methods={"GET"})
     */
    public function index()
    {
        $stages = $this->getDoctrine()->getRepository(StageClub::class)->findAll();
        $stageApiValidate = $this->getDoctrine()->getRepository(StageApi::class)->findAll();

        $suggestedApiStage = [];

        foreach ( $stageApiValidate as $currentId ) {
            $suggestedApiStage[] = $currentId->getIdApi();
        }

        return $this->render('stage/index.html.twig', [
            "stages" => $stages,
            'suggestedApiStage' => $suggestedApiStage
        ]);
    }


    /**
     * @Route("/stages-intern-ajax", name="stages_intern_ajax", condition="request.isXmlHttpRequest()")
     */
    public function stagesIntern(Request $request, SerializerInterface $serializer)
    {

        // on recupère tous les stages sous forme de colection d'objet
        $stages = $this->getDoctrine()->getRepository(StageClub::class)->findAll();

        // transform la collection d'oject en json
        $stagesJSON = $serializer->serialize($stages,'json');
        
        return new JsonResponse([
            'stages' => $stagesJSON,
        ]);
    }
}
