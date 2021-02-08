<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/", name="main_home", methods={"GET"})
     */
    public function home(){

        //demander l'affichage d'un fichier twig
        //une methode de controller doit toujours retourner une reponse
        return $this->render('main/home.html.twig');

    }

    /**
     * @Route("/about-us/", name="main_aboutus", methods={"GET"})
     */
    public function aboutUs(){

        return $this->render('main/about-us.html.twig');

    }

    /**
     * @Route("/legal-stuff/", name="main_legalStuf", methods={"GET"})
     */
    public function mentionsLegales(){

        return $this->render('main/legal-stuff.html.twig');

    }

    /**
     * @Route("/test/", name="main_test", methods={"GET"})
     */
    public function test(){

        return $this->render('main/test.html.twig');

    }


}
