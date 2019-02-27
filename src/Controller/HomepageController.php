<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(NewsRepository $newsRepository)
    {
        $news = $newsRepository->findAllNewsByDateOrderDsc();

        return $this->render('homepage/index.html.twig', [
            'news' => $news,
        ]);
    }
}
