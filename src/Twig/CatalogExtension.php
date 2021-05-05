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
            new TwigFunction('getregions', [$this, 'getAllRegions'])
        ];
    }

    public function getAllCategories(){
        $obPDO = new DBTools;
        $obPDO->init();
        $categories=$obPDO->execSqlQuery("select * from category");
        return $categories;
    }
    public function getAllRegions(){
        $obPDO = new DBTools;
        $obPDO->init();
        $regions=$obPDO->execSqlQuery("select distinct region from article");
        return ($regions);
    }

}

?>