<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/admin/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="document_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $document->getPath();
            // dd($file);

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('media_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                dump($e);
            }

            $document->setPath($fileName);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();
            $this->addFlash('success', 'Le document a été enregistré');

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $oldPath = $document->getPath();

        if(!empty($oldPath)) {
            $document->setPath(
                new File($this->getParameter('media_directory').'/'.$oldPath)
            );
        }

        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //si je souhaite setté un nouveau path pour un media existant => meme procedure que pour new
            if(!is_null($document->getPath())){

                $file = $document->getPath();
            
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('media_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    dump($e);
                }
                
                //je stocke le nouveau nom de fichier
                $document->setPath($fileName);

                //si je remplace mon ancien document par une nouveau , je teste dans un premier temps si il y en avait deja une à supprimer ;)
                if(!empty($oldPath)){
                    //fonction native a php qui supprime des fichiers
                    unlink(
                        $this->getParameter('media_directory') .'/'.$oldPath
                    );
                }

            } else { //sinon je garde l'ancienne valeur que j'avais deja en BDD
                $document->setPath($oldPath);//ancien nom de fichier
            }
            

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('document_index', [
                'id' => $document->getId(),
            ]);
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Document $document): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($document);
        $entityManager->flush();
        
        // je récupère le nom de mon fichier en bdd
        $fileName = $document->getPath();
        // j'efface le fichier uploadé dans public/uploads/media
        unlink($this->getParameter('media_directory') .'/'.$fileName);
        
        $this->addFlash('success', 'Le document a bien été supprimé');

        return $this->redirectToRoute('document_index');
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
