<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesFormType;
use App\Repository\ArticlesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticlesRepository $repo): Response
    {
            dump($repo);
            /*
                            //Pour sélectionner nos articles contenu dans la table articles en BDD? nous devons absolument avoir accès à la classe repository de la classe correspondante, en l'occurence 'Articles'(ArticleRepository).
                            //Un repository est une classe permettant de faire uniquement des selections en base de données (ex: SELECT * FROM articles)

                            //Pour cela nous avons instancié un objet $repo dans les paramètres de la méthode.
                            //Cet objet va contenir 
                         */


                             // dd(get_class_methods($repo));// dump() est une fonction prédéfinie de php nous permettant de voir toutes les méthodes

            $article = $repo->findBy(array(), array('created_at'=> 'asc'));// equivalant SQL =>SELECT * FROM articles ORDER BY createdAt ASC + fetchAll()

            // dd($articles);

        return $this->render('blog/index.html.twig', [
    'articles' => $article
        ]); 
    }

    /**
    * @Route("/", name="home")
    */


    public function home(): Response
    {
        return $this->render('blog/home.html.twig', [
            'titre1' => 'Bienvenue sur mon Blog',
            'age' =>23

        ]);
    }

 /**
    * @Route("/show/{id}", name="show")
    */
    public function show(Articles $article): Response
    {
        // dd($article);
       return $this->render('blog/show.html.twig', [
        'article' =>$article
        // 'article' =>$article->getId()
       ]);
    }


     /**
    * @Route("/new", name="new")
    */
    public function create(Articles $articleNew = null): Response
    {
            // dd($articleNew);
            //Nous avons créer une classe 'ArticlesFormType' qui permet de générer un formulaire d'ajout d'article.
            $form = $this->createForm(ArticlesFormType::class,$articleNew); //createForm() prend en paramètre le type de formulaire et la classe sur laquelle on injectera les valeurs entrée dans les inputs (name="title",name="content",etc)

            dd($form);
       return $this->render('blog/new.html.twig');
    }


    

}
