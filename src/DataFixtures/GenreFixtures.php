<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixtures extends Fixture
{
    private Filesystem $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }
    
    public function load(ObjectManager $manager): void
    {
        $this->filesystem->remove(__DIR__ . '/../../public/images/genres/');
        $this->filesystem->mkdir(__DIR__ . '/../../public/images/genres/');

        copy(
            './src/DataFixtures/genreImages/action.jpg',
            __DIR__ . '/../../public/images/genres/action.jpg'
        );

       $genre1 = new Genre();
       $genre1->setTitle('Action');
       $genre1->setImage('action.jpg');

       $genre2 = new Genre();
       $genre2->setTitle('Aventure');
       $genre2->setImage('aventure.jpg');

       $genre3 = new Genre();
       $genre3->setTitle('FPS');
       $genre3->setImage('fps.jpg');

       $genre4 = new Genre();
       $genre4->setTitle('Plateforme');
       $genre4->setImage('plateforme.jpg');

       $genre5 = new Genre();
       $genre5->setTitle('Combat');
       $genre5->setImage('combat.jpg');

       $manager->persist($genre1);
       $manager->persist($genre2);
       $manager->persist($genre3);
       $manager->persist($genre4);
       $manager->persist($genre5);

        $manager->flush();
    }
}
