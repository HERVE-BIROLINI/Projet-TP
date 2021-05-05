<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements OrderedFixtureInterface{

    const ARTICLES = [
        [
            'Title'         => "Foie gras d'oie",
            'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
            'Region'        => "sud-ouest",
            'Capacity'      => "300gr",
            'Price'         => 49.99,
            'Score'         => 3.5,
            'Category'      => 'Charcuterie',
        ],
        [
            'Title'         => "Saumon fumé",
            'Description'   => "Saumon fumé d'Ecosse, filet entier à découper.",
            'Region'        => "sud-ouest",
            'Capacity'      => "2kg",
            'Price'         => 79.99,
            'Score'         => 5,
            'Category'      => 'Produit de la mer',
        ],
        [
            'Title'         => "Rillettes de poisson",
            'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
            'Region'        => "Bretagne",
            'Capacity'      => "90gr",
            'Price'         => 29.99,
            'Score'         => 3.5,
            'Category'      => "Produit de la mer",
        ],
        [
            'Title'         => "Foie gras de canard",
            'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
            'Region'        => "Perigord",
            'Capacity'      => "150gr",
            'Price'         => 29.99,
            'Score'         => 3,
            'Category'      => "Luxe",
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
