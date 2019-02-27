<?php

namespace App\Controller;

use App\Entity\News;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsController extends AbstractController
{
    /**
     * @Route("/actualites/{id}", name="news_show")
     */
    public function index(News $news)
    {
        return $this->render('news/index.html.twig', [
            'news' => $news,
        ]);
    }
}
