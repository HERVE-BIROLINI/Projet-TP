<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements OrderedFixtureInterface{

    const ARTICLES = [
        ['Title'        => "Foie gras d'oie de Charente 300gr",
        'Description'   => "Block de Foie gras d'oie de 300gr",
        'Region'        => "Charente",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 4.2,
        'Category'      => 'Charcuterie', 
        ],

	['Title'        => "Caviar de Corrèze 50gr",
        'Description'   => "Caviar préparé à Neuvic",
        'Region'        => "Corrèze",
        'Capacity'      => "50gr",
        'Price'         => 249.99,
        'Score'         => 4.8,
        'Category'      => 'Luxe', 
        ],

	['Title'        => "Truffes du Périgord 50gr",
        'Description'   => "Truffes noires du Périgord",
        'Region'        => "Périgord",
        'Capacity'      => "50gr",
        'Price'         => 75.99,
        'Score'         => 4.3,
        'Category'      => 'Luxe', 
        ],

	['Title'        => "Huitres de Bretagne",
        'Description'   => "Huitres creuse de Bretagne, taille 1 à 5, vendue à la douzaine",
        'Region'        => "Bretagne",
        'Capacity'      => "à la douzaine",
        'Price'         => 12.99,
        'Score'         => 4.3,
        'Category'      => 'Produits de la mer', 
        ],

	['Title'        => "Filet de Saumon de Normandie 150gr",
        'Description'   => "Filet de Saumon de Normandie tendre et peu gras de 150gr",
        'Region'        => "Normandie",
        'Capacity'      => "150gr",
        'Price'         => 4.99,
        'Score'         => 4.3,
        'Category'      => 'Produits de la mer',
        ],

	['Title'        => "Côte de boeuf Charolaise 500gr",
        'Description'   => "Une Côte de boeuf Charolais de 500gr",
        'Region'        => "Bourgogne",
        'Capacity'      => "500gr",
        'Price'         => 34.99,
        'Score'         => 4.3,
        'Category'      => 'Charcuterie', 
        ],

	['Title'        => "Tartare de boeuf 200gr",
        'Description'   => "Tartare de boeuf de 200gr provenance Bourgogne",
        'Region'        => "Bourgogne",
        'Capacity'      => "200gr",
        'Price'         => 9.99,
        'Score'         => 4.3,
        'Category'      => 'Charcuterie', 
        ],

	['Title'        => "entrecôte de boeuf Charolais 250gr",
        'Description'   => "Une entrecôte de boeuf Charolais de 250gr",
        'Region'        => "Bourgogne",
        'Capacity'      => "250gr",
        'Price'         => 14.99,
        'Score'         => 4.3,
        'Category'      => 'Charcuterie',
        ],
        [
            'Title'         => "Truffe",
            'Description'   => "Truffes noires du Perigord.",
            'Region'        => "Perigord",
            'Capacity'      => "100gr",
            'Price'         => 249.99,
            'Score'         => 5,
            'Category'      => "Luxe",
        ],
        // ....
    ];
// Pour déclencher LOAD à partir du Terminal
// bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager){
        foreach (self::ARTICLES as $item) 
        {
            $article = new Article;
            // $article->
            $article->setTitle($item['Title']);
            $article->setDescription($item['Description']);
            $article->setRegion($item['Region']);
            $article->setCapacity($item['Capacity']);
            $article->setPrice($item['Price']);
            $article->setScore($item['Score']);
            // $article->setTitle("Titre " . $count);
            // $article->setUri("Uri Fixture" . $count);

            // $article->setCategory($Article['Category']);
            $article->setCategory($this->getReference($item['Category']));

            // utiliser AVANT Persist le setReference, 
            // afin de stocker en mémoire les instances des objets 
            // qui dans un second temps (chargement de Article),
            // récupèrera la donnée...
            // REFERENCE POUR TABLE IMAGE
            // $this->setReference($Article['Label'],$article);

            $manager->persist($article);
        }
        //
        $manager->flush();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder(): int{
        return 2;
    }
}
