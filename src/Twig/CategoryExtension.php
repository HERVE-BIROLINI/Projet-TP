<?php

namespace App\Twig;

use App\Utils\DBTools;
use App\Entity\Category;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoryExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('aire', [$this, 'calculateArea']),
            new TwigFunction('categories', [$this, 'getAllCategories'])
        ];
    }

    public function getAllCategories(){

        $obPDO = new DBTools;
        $obPDO->init();
        $categories=$obPDO->execSqlQuery("select * from category");
        return $categories;
    }

    public function calculateArea(int $width, int $length)
    {return $width * $length;}

    // public function getName(){return 'twigext';}
}

?>