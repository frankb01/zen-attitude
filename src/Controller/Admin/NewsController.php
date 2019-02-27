<?php

namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\NewsType;
use App\Repository\NewsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin", name="admin_")
 */
class NewsController extends AbstractController
{
    /**
     * @Route("/actualites", name="news_list")
     */
    public function list(NewsRepository $newsRepository)
    {
        $news = $newsRepository->findAllNewsByDateOrderDsc();

        return $this->render('admin/news_list.html.twig', [
            'news' => $news,
        ]);
    }

    /**
     * @Route("/actualites/ajout", name="news_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();
            $this->addFlash('success', 'Nouvelle actualité ajoutée.');
            return $this->redirectToRoute('admin_news_list');
        }

        return $this->render('admin/news_new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/actualites/{id}/modification", name="news_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Actualité modifiée.');
            return $this->redirectToRoute('admin_news_list');
        }

        return $this->render('admin/news_edit.html.twig', [
            'form' => $form->createView(),
            'news' => $news,
        ]);
    }

    /**
     * @Route("/actualites/{id}/suppression", name="news_delete", methods={"GET","POST"})
     */
    public function delete(Request $request, News $news)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($news);
        $em->flush();
        $this->addFlash('success', 'Actualité supprimée.');
        return $this->redirectToRoute('admin_news_list');
    }
}
