<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements OrderedFixtureInterface{

    const ARTICLES = [
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 10,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras de canard",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 9,
        'Image'         => "image",
        ],
        ['Title'        => "Pâté de campagne",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 8,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 8,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 10,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 9,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 9,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 8,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 10,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 8,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 10,
        'Image'         => "image",
        ],
        ['Title'        => "Foie gras d'oie",
        'Description'   => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam esse quae quod blanditiis modi? Quibusdam eius sed, veniam exercitationem molestias aperiam neque atque vel aliquam obcaecati in necessitatibus eos reiciendis.",
        'Region'        => "sud-ouest",
        'Capacity'      => "300gr",
        'Price'         => 49.99,
        'Score'         => 3.5,
        'Category'      => 9,
        'Image'         => "image",
        ],
        // ....
    ];
// Pour déclencher LOAD à partir du Terminal
// bin/console doctrine:fixtures:load
    public function load(ObjectManager $manager){
        foreach (self::ARTICLES as $Article) {
            $obArticle = new Article(
                // $Article['Title'],
                // $Article['Description'],
                // $Article['Region'],
                // $Article['Capacity'],
                // $Article['Price'],
                // $Article['Score'],
                // $Article['Category'],
                // $Article['Image'],
            );
            // $obArticle->
            $obArticle->setTitle($Article['Title']);
            $obArticle->setDescription($Article['Description']);
            $obArticle->setRegion($Article['Region']);
            $obArticle->setCapacity($Article['Capacity']);
            $obArticle->setPrice($Article['Price']);
            $obArticle->setScore($Article['Score']);
            // $obArticle->setCategory($Article['Category']);
            $obArticle->setImage($Article['Image']);
            // $article->setTitle("Titre " . $count);
            // $article->setUri("Uri Fixture" . $count);
            $manager->persist($obArticle);
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
        return 3;
    }
}
