<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Utils\DBTools;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article", name="article_")
 */
class ArticleController extends AbstractController
{

    /**
     * Route("/category/{id}", name="region", methods={"GET"})
     * @Route("/region/{region}", name="region")
     */
    public function region($region): Response
    {
        $obPDO = new DBTools;
        $obPDO->init();
        $kartId=$obPDO->execSqlQuery("select * from article where region='".$region."'");
        //
        return $this->render('article/category.html.twig',
            ['articles'  => $kartId,]
        );
    }
    /**
     * @Route("/category/{id}", name="category", methods={"GET"})
     */
    public function category(ArticleRepository $articleRepository, Category $category): Response
    {
        $obPDO = new DBTools;
        $obPDO->init();
        $articles=$obPDO->execSqlQuery("select * from article");//$articleRepository->findAll(),
        // dd($articles);
        return $this->render('article/category.html.twig', [
            'articles'  => $articles,
            // 'articles'  => $articleRepository->findAll(),
            'category'  => $category,
        ]);
    }
    /**
     * @Route("/card/{id}", name="card", methods={"GET"})
     */
    public function card(Article $article): Response
    {
        return $this->render('article/card.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/", name="index", methods={"GET"})
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            //
            return $this->redirectToRoute('article_index');
        }
        //
        return $this->render('article/new.html.twig', [
            'article'   => $article,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_index');
    }
}
