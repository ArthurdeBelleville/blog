<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * methode qui affiche la page d'acceuil
     * 
     * @Route("/", name="home")
     */
    public function home(): Response
    {

        return $this->render('blog/home.html.twig', ['title'=> "Bienvenue sur le blog de symfony", 'age' => 25
        ]);

    }

    /**
     * 
     * Methode permettant d'afficher tout la liste des articles stockés en BDD
     * 
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'title' => 'Listes des Articles',
        ]);
    }

    /**
     * methode permettant dafficher le details d'un articles 
     * 
     * @Route("/blog/12", name="blog_show")
     */
    public function show(): Response
    {
        return $this->render('blog/show.html.twig');
    }
}
