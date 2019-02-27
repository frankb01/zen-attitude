<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\AdminNewMemberType;
use App\Form\AdminEditMemberType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/utilisateurs", name="users_list")
     */
    public function usersList(UserRepository $userRepository)
    {
        $users = $userRepository->findAllUserByNameOrderAsc();

        return $this->render('admin/users_list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/utilisateur/ajout", name="user_new", methods={"GET","POST"})
     */
    public function userNew(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(AdminNewMemberType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Nouvel utilisateur ajouté.');
            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/user_new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/modification", name="user_edit", methods={"GET","POST"})
     */
    public function userEdit(Request $request, User $user, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createForm(AdminEditMemberType::class, $user);

        // Tant que je n'ai pas appelé la methode handleRequest j'ai toujours mon objet non mis a jour. De ce fait , je vais récupérer l'ancien mot de passe au cas où je ne souhaite pas le modifier et éviter l'entrée en DB d'un mot de passe vide
        $oldPassword = $user->getPassword();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Si mon nouveau mdp est vide = pas de changement pour l'utilisateur  => on reprend l'ancien mot de passe
            if(empty($form->get('password')->getData()) || is_null($form->get('password')->getData())){
                $encodedPassword = $oldPassword;
            } else { // Sinon j'encode le nouveau mot de passe comme dans la fonction new
                $encodedPassword = $encoder->encodePassword($user, $form->get('password')->getData());
            }
            //de meme , il faut setter la nouvelle valeur a password si je souhaite sa modification
            $user->setPassword($encodedPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Profil modifié.');
            return $this->redirectToRoute('admin_users_list');
        }

        return $this->render('admin/user_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/suppression", name="user_delete", methods={"GET","POST"})
     */
    public function userDelete(Request $request, User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Utilisateur supprimé.');
        return $this->redirectToRoute('admin_users_list');
    }
}
