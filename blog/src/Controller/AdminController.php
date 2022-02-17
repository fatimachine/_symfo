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

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

/**
     * @Route("/admin/remove_article/{id}",name="admin_remove_article")
     * @Route("/admin/article", name="admin_articles")
     */
    public function adminArticles(EntityManagerInterface $manager, ArticlesRepository $repo, Articles $article = null): Response 
    {
       $columns = $manager->getClassMetadata(Articles::class)->getFieldNames();
       $articles = $repo->findAll();


       if($article) {
           $id = $article->getId();

           $manager->remove($article);
           $manager->flush();

           $this->addFlash('success', "L'article id: $id bien été supprimé.");

           return $this->redirectToRoute("admin_articles");
       }
       return $this->render("admin/admin_articles.html.twig", [
           'columns' => $columns,
           'articles' => $articles
       ]);
    }

//pour passer en mode modification nous définissons une route différente et nous lui passons un {id} en paramètre, symfony s'occupe du reste

    /** 
     *@Route("/admin/edit_articles/{id}", name="admin_edit_articles")
     */
    public function editArticle(Articles $articleNew = null, Request $request, EntityManagerInterface $manager): Response
    {
              if(!$articleNew)
              {
                  $articleNew = new Articles();
              }


              $form = $this->createForm(ArticlesFormType::class,$articleNew); 
  
              $form->handleRequest($request);

               if($form->isSubmitted() && $form->isValid())
               {
                  if(!$articleNew->getId()) {
  
                      $articleNew->setCreatedAt(new \Datetime);
                  }
                   $manager->persist($articleNew); 
  
                   $manager->flush();

                    $this->addFlash('success', 'Votre article a bien été modifié');

                    return $this->redirectToRoute('admin_articles');
               }
  
         return $this->render('admin/admin_edit_articles.html.twig',[
          'formulaire'=>$form->createView(), 
          'modeEdit'=>$articleNew->getId()
         ]);
        
      }
  
}
