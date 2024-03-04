<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //EntityManagerInterface $entityManager
        //injection de dependance ! =>je recupere entitymanager pour interagir avec la BDD
        //https:://symfony.com/doc/6.4/doctrine.html#fetching-objects-from-the-database

        $articles = $entityManager->getRepository(Article::class)->findAll();

        //recuperer tous les articles en BDD
        //et les envoyer à ma vue
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{id}', name: 'app_get_article_by_id')]
    public function getArticleById(EntityManagerInterface $entityManager, int $id): Response

    {
        //pour recuperer le parametre id en url,j'ai juste declarer en argument de sa methode
        $article= $entityManager->getRepository(Article::class)->find($id);
        return $this->render('articles/show_article.html.twig', [ 
            'article'=>$article,
        ]);
    }
}
