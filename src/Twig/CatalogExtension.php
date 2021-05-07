<?php

namespace App\Twig;

use App\Utils\DBTools;
use App\Entity\Category;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CatalogExtension extends AbstractExtension
{
    public function getFunctions(){
        return [
            new TwigFunction('getcategories', [$this, 'getAllCategories']),
            new TwigFunction('isusedcategory', [$this, 'isUsedCategory']),
            new TwigFunction('getregions', [$this, 'getAllRegions']),
            new TwigFunction('bestsellers', [$this, 'getBestSellers']),
            new TwigFunction('getimages', [$this, 'getImages']),
            
        ];
    }

    public function getAllCategories(){
        $obPDO = new DBTools;
        $obPDO->init();
        $categories=$obPDO->execSqlQuery("select * from category");
        return $categories;
    }
    public function isUsedCategory($category): bool{
        $obPDO = new DBTools;
        $obPDO->init();
        $articles=$obPDO->execSqlQuery("select * from article where category_id=".$category);
        if(count($articles)>0){
            return true;
        }
        else{return false;}
    }
    public function getAllRegions(){
        $obPDO = new DBTools;
        $obPDO->init();
        $regions=$obPDO->execSqlQuery("select distinct region from article");
        return ($regions);
    }
    public function getBestSellers(){
        $obPDO = new DBTools;
        $obPDO->init();
        $regions=$obPDO->execSqlQuery("select * from article where bestseller=1");
        return ($regions);
    }
    public function getImages(string $article){
        $obPDO = new DBTools;
        $obPDO->init();
        $article=intval($article);
        $regions=$obPDO->execSqlQuery("select pathname from picture where article_id=".$article);
        // dd($regions);
        if(!isset($regions[0])){
            $regions=array(['pathname'=>'no-image.png']);
        }
        return ($regions);
    }

}

?>