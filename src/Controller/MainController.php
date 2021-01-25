<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController {

    /**
     * @Route("/")
     */
    public function home(){

        //demander l'affichage d'un fichier twig
        //une methode de controller doit toujours retourner une reponse
        return $this->render('main/home.html.twig');

    }
}
