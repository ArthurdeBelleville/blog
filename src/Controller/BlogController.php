<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\Mapping\Id;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
     * Méthode permettant d'insérer et de modifier un article
     * 
     *  @Route("/blog/new", name="blog_create")
     *  @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function create(Article $articleCreate = null, Request $request, EntityManagerInterface $manager) : Response
    {
// Si la variable $articleCreate N'EST PAS, si elle ne contient aucun article de la BDD, cela veut dire nous avons envoyé la route '/blog/new', c'est une insertion, on entre dans le IF et on crée une nouvelle instance de l'entité Article, création d'un nouvel article
        // Si la variable $articleCreate contient un article de la BDD, cela veut dire que nous avons envoyé la route '/blog/id/edit', c'est une modifiction d'article, on entre pas dans le IF
        if(!$articleCreate)
        {
        $articleCreate = new Article;
        }

   /* dump($Request);

   // return $this->render('blog/create.html.twig');

   // if($Request->request->count() > 0)
    {
       // $articleCreate = new Article;

      //  $articleCreate->setTitle($Request->request->get('title'))
                      ->setContent($Request->request->get('content'))
                      ->setImage($Request->get('image'))
                      ->setCreateAt(new \DateTime);

                      dump($articleCreate);
                      
                      $manager->persist($articleCreate);
                      $manager->flush();


                      return $this->redirectToRoute('blog_show',['id' => $articleCreate->getId()]
                    );

    }

    return $this->render('blog/create.html.twig');
    */




$form = $this->createForm(ArticleFormType::class, $articleCreate );

/*$form = $this->createFormBuilder($articleCreate)
->add('title')

->add('content', TextareaType::class, ['attr' => [ 'placeholder' => "conteneur de l'article"] ])

->add('image')

->getForm();*/

$form->handleRequest($request);

dump($articleCreate);

if($form->isSubmitted() && $form->isValid())
{
   

    if(!$articleCreate->getId())
            {
                $articleCreate->setCreateAt(new \DateTime);
            }
            $articleCreate->setCreateAt(new \DateTime);

    $manager->persist($articleCreate);
    $manager->flush();

    return $this->redirectToRoute('blog_show', [ 'id' => $articleCreate->getId() ]);

}

return $this->render('blog/create.html.twig', [
    'formArticle' => $form->createView(), //on transmet sur le template le form via createView() sur create.html.twig

    'editMode' => $articleCreate->getId() // Cela permettra dans le template de savoir si l'article possède un ID ou non. Si c'est une insertion ou une modif

]);


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
