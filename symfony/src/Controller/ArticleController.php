<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // to save the article to the db we need an entity manager
        $entityManager = $doctrine->getManager();

        // an instance of our article entity to create a new db entry
        $article = new Article();
        $article->setTitle('our first title');

        // to store the data use persist
        //$entityManager->persist($article);
        // the sql statements are flushed down the line and then send to the db for exc
        //$entityManager->flush();
        //return new Response('saved a new article');

        // find an specific article in the db
        $getArticle = $entityManager->getRepository(Article::class)->findOneBy([
            'id'=>1
        ]);

        // remove something from the db
        $entityManager->remove($getArticle);
        $entityManager->flush();

         return $this->render('article/index.html.twig', [
            'article' => $getArticle,
        ]);

    }
}
