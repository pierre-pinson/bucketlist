<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Services\Censurator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wish", name="wish_list")
     */
    public function list(WishRepository $wishRepository):Response{

        //aller chercher tous les wish ds la bdd grace aux methodes du repository
        $wishs= $wishRepository->findBy(
            [],//clause where , vide si non utile
            ["dateCreated"=>"DESC"]); //

        return $this->render('wish/list.html.twig', ["wishs"=>$wishs]);
    }


    /**
     * @Route("/wish/detail/{id}", name="wish_detail", requirements={"id": "\d+"})
     */
    public function detail(WishRepository $wishRepository,$id):Response{

        //aller chercher ds la bdd le wish dont l'id est passé en url
        $wish= $wishRepository->find($id);

        //si pas d'existence en bdd, erreur 404
        if(!$wish){
            throw $this->createNotFoundException('Ce souhait est déjà réalisé');
        }

        return $this->render('wish/detail.html.twig',[
            //passe l'id present dans l'url à twig
            "wish_id"=>$wish
        ]);
    }

    /**
     * @Route("/creation",name="wish_creation")
     */
    public function creation(Censurator $censurator){

        //créer une istance de la classe
        $wish=new Wish();
        //hydratation de l'instance
        $wish->setAuthor('pierre');
        $wish->setDateCreated(new \DateTime());
        $wish->setDescription('voir Venise et mourir');
        $wish->setTitle('Venise');
        $wish->setIsPublished(true);

        //appel au service pour supprimer les mots non autorisés



        //appel a entitymanager pour la sauvegarder ds la bdd
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($wish);
        $entityManager->flush();

        return new Response();

    }

    /**
     * @Route("/profile/wish/create", name="wish_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager,Censurator $censurator):Response{

        //creation du formulaire+nouvelle instance ds laquelle seront stockées les infos reçues du form
        $wish = new Wish();
        //ajouter le nom de l'utilisateur par défaut
        $user=$this->getUser();
        $wish->setAuthor($user->getUsername());
        //on associe l'instance au formulaire
        $form = $this->createForm(WishType::class, $wish);
        //on place les données du form ds l'instance
        $form ->handleRequest($request);



        //on verifie la validation du form
        if($form->isSubmitted()&& $form->isValid()){

            //appel au service pour supprimer les mots non autorisés
            $text =$wish->getDescription();
            $text2 = $censurator->purify($text);
            $wish->setDescription($text2);

            //on ajoute les données manquantes, dont la date du moment de la creation
            $wish ->setDateCreated(new \DateTime());
            $wish ->setIsPublished(true);

            //on effectue l'insert
            $entityManager->persist($wish);
            $entityManager->flush();

            //message de confirmation
            $this->addFlash("success","Votre souhait a été enregistré");

            //redirection vers la page de detail donc ajout de l'id du souhait en parametre
            //au pire rediriger vers la page du form de façon a vider les champs de saisie
            return $this->redirectToRoute('wish_detail', ['id'=>$wish->getId()]);

        }

        return $this ->render('wish/create.html.twig',[
            "wish_form" =>$form->createView()
        ]);
    }


}
