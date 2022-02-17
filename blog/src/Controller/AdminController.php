<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
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
     * @Route("/admin/remove_article/{id}",name="admin_remove-article")
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
       return $this->render("admin_articles.html.twig", [
           'columns' => $columns,
           'articles' => $articles
       ]);
    }



}
