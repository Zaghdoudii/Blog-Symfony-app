<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker= \Faker\Factory::create('fr_FR');

        //Creer 03 categories fakees
for($i=1 ; $i<=3; $i++){
    $category= new Category();
    $category->setTitle($faker->sentence())
             ->setDescription($faker->paragraph());

    $manager->persist($category);
//Creer entre 04 et 06 articles

for($j=1; $j <= 10; $j++){
    $article= new Article();
   
 $content = '<p>'.join($faker->paragraphs(5), '/p><p>'). '</p>';
   

    $article->setTitle($faker->sentence())
            ->setContent($content)
            ->setImage($faker->imageUrl())
            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
            ->setCategory($category);
            $manager->persist($article);
        

        //on donne des commentaires a l'article

        for($k=1; $k<=mt_rand(4, 10); $k++){
             $comment= new Comment();
             $content = '<p>'.join($faker->paragraphs(2), '/p><p>'). '</p>';
            
             $days= (new \DateTime())->diff($article->getCreatedAt())->days;
            
             $minimum= '-'. $days. 'days'; // -100 days

             $comment->setAuthor($faker->name)
                     ->setContent($content)
                     ->setCreatedAt($faker->dateTimeBetween($minimum))
                     ->setArticle($article);

                     $manager->persist($comment);
        }
   }
}
$manager->flush();
    }
}
