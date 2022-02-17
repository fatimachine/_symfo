<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesFormType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

//Pour passer en mode modif ,ous définissons une route différente et nous lui passons un {id}en paramètre,symfony s'occupe du reste
     /**
    * @Route("/new", name="new")
    * @Route("/edit/{id}", name="edit")
    */
    public function create(Articles $articleNew = null, Request $request, EntityManagerInterface $manager): Response
  {
            if(!$articleNew){
                $articleNew = new Articles();
            }
            // dd($articleNew);
            //Nous avons créer une classe 'ArticlesFormType' qui permet de générer un formulaire d'ajout d'article.
            $form = $this->createForm(ArticlesFormType::class,$articleNew); //createForm() prend en paramètre le type de formulaire et la classe sur laquelle on injectera les valeurs entrée dans les inputs (name="title",name="content",etc)

            // dd($form);
            $form->handleRequest($request);//On pioche la méthode handleRequest()de la classeRequest(composant Htppfoundation).Cela va nous permettre de récupérer chaque saisie dans le formulaire ($_POST['title'], $_POST['content']etc) et de les binder (binValue)directement dans les setters correspondant à $articleNew($_POST['title']=> Articles->setTitle,etc).

             // dd($request);
             if($form->isSubmitted() && $form->isValid())
             
             {
            
                if(!$articleNew->getId()) {

                    $articleNew->setCreatedAt(new \Datetime);
                }
                 $manager->persist($articleNew); // on met les donnéees récupérées dans $articleNew en mémoire avant envoi en BDD 

                 $manager->flush();// on insert tout dans notre table articles en BDD.

                 //redirectToroute() est une fonction de redirection (ex: header (Location:blog?id=15.php))
                    return $this->redirectToRoute('show', [
                        'id'=> $articleNew->getId() // on recupère l'id de l'article que l'on vient d'inserer en base de données 
                    ]);
             }

       return $this->render('blog/new.html.twig',[
        'formulaire'=>$form->createView(), // ici on renvoie le formulaire $form avec tous les champs requis
        'modeEdit'=>$articleNew->getId()
       ]);
      
    }

}
