<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\Mapping\Id;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
 * @route("/blog/new", name="blog_create")
 * 
 */
public function create(Request $Request): Response
{

    dump($Request);

    return $this->render('blog/create.html.twig');
}






/*
            Pour selectionner des données dans une table SQL, nous devons absolument avoir accès à la classe Repository de l'entité correspondante 
            Un Repository est une classe permettant uniquement d'executer des requetes de selection en BDD (SELECT)
            Nous devons donc accéder au repository de l'netité Article au sein de notre controller  

            On appel l'ORM doctrine (getDoctrine()), puis on importe le repositoritory de la classe Article grace à la méthode getRepository()
            $repo est un objet issu de la classe ArticleRepository
            cet objet contient des méthodes permettant d'executer des requetes de selections
            findAll() : méthode issue de la classe ArticleRepository permettant de selectionner l'ensemble de la table SQL 'Article'
        */
// on envoie sur le template, les articles selectionnés en BDD afin de pouvoir les afficher dynamiquement sur le template à l'aide du langage Twig



    /**
     * 
     * Methode permettant d'afficher tout la liste des articles stockés en BDD
     * 
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo): Response
    {
        //$repo = $this->getdoctrine()->getRepository(Article::class);

        dump($repo);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'title' => 'Listes des Articles',
            'articles' => $articles
        ]);
    }

    /**
     * methode permettant dafficher le details d'un articles 
     * 
     * @Route("/blog/{id}", name="blog_show")
     */
    public function show(Article $article): Response
    {
       // $repoArticles = $this->getdoctrine()->getRepository(Article::class);

       // dump($repoArticles);

       // dump($id);

        //$article = $repoArticles->find($id);

        dump($article);

        return $this->render('blog/show.html.twig', [ 'articleTwig' =>$article ]); 

           
    }

}
