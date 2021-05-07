<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Kart;
use App\Entity\User;
use App\Utils\DBTools;
use App\Repository\ArticleRepository;
use App\Repository\KartItemRepository;
use App\Repository\KartRepository;
use DateTime;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/kart", name="kart_")
 */
class KartController extends AbstractController
{

    /**
     * 
     * @Route("/add/{id}", name="add")
     */
    public function add(Article $article
                        , SessionInterface $session
                        , Request $request
                        ){
        // $session->set('kart',[$article]);
        // récupération du panier courant
        $kart=$session->get('kart',[]);
        // vérification de l'existance de l'article au panier
        if(!empty($kart[$article->getId()])){
            $kart[$article->getId()]++;
        }
        else{
            $kart[$article->getId()]=1;
        }
        // onsauvegarder dans la session
        $session->set('kart',$kart);
        
        $this->addFlash('adding_to_cart',"Article ajouté au panier...");
        return $this->redirect($request->headers->get('referer'));
        // return $this->redirectToRoute('kart_user');
    }
    /**
     * 
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Article $article, SessionInterface $session){
        // récupération du panier courant
        $kart=$session->get('kart',[]);
        // vérification de l'existance de l'article au panier
        if(!empty($kart[$article->getId()])){
            if($kart[$article->getId()]>1){
                $kart[$article->getId()]--;
            }
            else{
                unset($kart[$article->getId()]);
            }
        }
        // on sauvegarde dans la session
        $session->set('kart',$kart);
        $this->addFlash('deleting_from_cart',"Article supprimé du panier...");
        return $this->redirectToRoute('kart_user');
    }
    /**
     * 
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Article $article, SessionInterface $session){
        // récupération du panier courant
        $kart=$session->get('kart',[]);
        // vérification de l'existance de l'article au panier...
        if(!empty($kart[$article->getId()])){
            // ... avant 'vidage'
            unset($kart[$article->getId()]);
        }
        // on sauvegarde dans la session
        $session->set('kart', $kart);
        $this->addFlash('deleting_from_cart',"Article(s) supprimé(s) du panier...");
        // return $this->redirect($request->headers->get('referer'));
        return $this->redirectToRoute('kart_user');
    }
    /**
     * 
     * @Route("/delete/", name="deleteall")
     */
    public function deleteAll(SessionInterface $session){
        $session->remove('kart');
        $this->addFlash('deleting_from_cart',"Panier vidé...");
        return $this->redirectToRoute('kart_user');
    }




    /**
     * 
     * @Route("/user", name="user")
     */
    public function userkart(SessionInterface $session
                            ,ArticleRepository $articleRepository
                            ): Response
    {
        // Entrée dans la méthode
        if(!isset($_POST['validKart'])){
            $kart=$session->get('kart',[]);
            $kartItems=[];
            $total=0;
            //
            foreach($kart as $id => $quantity){
                $article=$articleRepository->find($id);
                array_push($kartItems,[
                    'article'   => $article,
                    'quantity'  => $quantity
                ]);
                $total+=$article->getPrice()*$quantity;
            }
            return $this->render('kart/userkart.html.twig', [
                'kartItems' => $kartItems,
                'total'     => $total,
            ]);
        }
        // Retour dans la méthode : $_POST['validKart']='ok'
        else{
            $kart=$session->get('kart',[]);
            $user=$this->getUser();
            $obPDO = new DBTools;
            $obPDO->init();
            $curDateTime=new DateTime();
            // écrire dans les tables...
            // ... en commençant par le kart
            $obPDO->execSqlQuery(
                "insert into kart (user_id, creationdate, status) values (?,?,?);"
                ,array($user->getId(),$curDateTime->format('Y-m-d H:i:s'), 1)
            );
            $kartId=$obPDO->execSqlQuery("select max(id) from kart")[0][0];
            // ... puis les kart_articles
            foreach($kart as $id => $quantity){
                $obPDO->execSqlQuery(
                    "insert into kart_item (kart_id, article_id, quantity) values (?,?,?);"
                    ,array(intval($kartId),intval($id),intval($quantity))
                );
            }
            // supprime le panier, retourne à l'affichage
            $session->remove('kart');
            return $this->redirectToRoute('kart_user');
        }
    }

    /**
     * 
     * @Route("/history", name="history", methods={"GET","POST"})
     */
    public function orderHistory(KartRepository $kartRepository
                                , KartItemRepository $kartitemRepository
                                ,ArticleRepository $articleRepository
                                // ,SessionInterface $session
                                ): Response
    {
        $user=$this->getUser();
        // $orders=$kartRepository->findAll();
        $karts=$kartRepository->findBy(['user'=>$user]);
        // récupération des totaux dans la table kart_item
        $totals=[];
        $totalarticles=0;
        $totalprice=0;
        // pour chaque commande...
        foreach($karts as $kart){
            $totalarticles=0;
            $totalprice=0;
            $kartitems=$kartitemRepository->findBy(['kart'=>$kart]);
            // ... somme des totaux de chaque article, et somme des prix
            foreach($kartitems as $kartitem){
                $totalarticles+=$kartitem->getQuantity();
                $totalprice+=$kartitem->getQuantity()*$kartitem
                    ->getArticle()->getPrice();
            }
            $totals[$kart->getId()]=
                [
                    'totalarticles' => $totalarticles,
                    'totalprice'    => $totalprice
                ];
        }
        // 1/ Entrée dans la méthode, ou retour à la vue "liste"...
        if(!isset($_POST['view']) or $_POST['view']=='list'){
            // dd($orders);
            return $this->render('kart/orderhistory.html.twig', [
                'view'      => 'list',
                'orders'    => $karts,
                'totals'    => $totals,
            ]);
        }
        // 2/ Retour dans la méthode : $_POST['view']='kart_id'
        else{
            $obPDO = new DBTools;
            $obPDO->init();
            $kartItems=$obPDO->execSqlQuery(
                "select article.*,kart_item.quantity from article "
                ."inner join kart_item on article.id=kart_item.article_id "
                ."inner join kart on kart.id=kart_item.kart_id "
                ."WHERE kart.id=".$_POST['view']
            );
            //
            return $this->render('kart/orderhistory.html.twig', [
                'view'      => 'details',
                'kartItems' => $kartItems,
            ]);
        }
    }



    /**
     * @Route("/", name="kart_index")
     */
    // public function index(User $user, KartRepository $kartRepository): Response
    // {
    //     return $this->render('kart/index.html.twig', [
    //         'controller_name' => 'KartController',
    //     ]);
    // }


    //     public function monPanier(KartRepository $kartRepository){
    //         $user=$this->getUser();
    // dd($user);
    //         $kart=$kartRepository->findOneBy(
    //             [
    //                 'user'  =>  $user,
    //             ]
    //             );
    // dd($kart);
    //     }
    // $panier_en_cours=$kartRepository->findLast($user-getId());
    // public function findLast(User $user){
    //     return $this->createQueryBuilder('k')
    //         ->andWhere('k.user = :val')
    //         ->setParameter('val', $user)
    //         ->orderBy('k.id','DESC')
    //         ->setMaxResults(1)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

}
