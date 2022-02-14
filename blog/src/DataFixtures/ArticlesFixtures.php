<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Articles;

class ArticlesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //Ici la méthode load() du bundle/bibliothèques orm-fixtures, v=ça va nous permettre d'insérer des données fictives relatives à notre entité 'Articles', en BDD.
        //Pour cela nous avons besoin d'instatié un objet de notre entité 'Articles'.


         // $product = new Product();
            for ($i=1; $i <=10; $i++)
             { 
                 //On instancie l'entité Articles.php qui se trouve dans le dossier (namespace) App\Entity
                $article = new Articles();
                $article ->setTitle("Titre de l'article n° :" .$i)
                ->setContent("<p>Contenu de l'article n° $i" .$i. "</p>")
                ->setImage("https://via.placeholder.com/350x150")
                ->setAuthor("Fatima")
                ->setCreatedAt(new \DateTime()); //la class DateTime de php est en dehors 


                $manager->persist($article); // la méthode persist met en mémoire les données que l'on envoit dans les setters
            }

       

        $manager->flush(); // la méthode flush() insère réellement (via la requête SQL) les différentes manipulation que nous avons fait ici.
    }
}
