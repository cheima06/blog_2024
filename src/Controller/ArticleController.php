<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaires;
use App\Form\ArticleType;
use App\Form\CommentaireType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository,CategoryRepository $categoryRepository, 
    PaginatorInterface $paginator, 
    Request $request ): Response
    {

        $articles = $paginator->paginate(
            $articles= $articleRepository->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/

        );

        
        return $this->render('article/index.html.twig', [
            'articles' => $articles,

            
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre article a bien été ajouté'
            );

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show(Article $article, Request $request, EntityManagerInterface $entityManager): Response
    {
        $commentaire= new Commentaires;
        $form = $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $commentaire->setName($this->getUser());
            $commentaire->setArticle($article);
            $commentaire->setDate(new \DateTime);
            $commentaire->setIsVerified(false);
            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre message a bien ete ajouté !'
            );

        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'CommentaireForm'=>$form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {// request est basé sur html sert a recup donnée requete et formulaire
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/category/{id_category}', name: 'app_get_article_by_category', methods: ['GET'])]
    public function getArticleByCategory(EntityManagerInterface $entityManager, int $id_category): Response
    {
        $articles=$entityManager->getRepository(Article::class)->findBy(array('category'=>$id_category));
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

 

}
