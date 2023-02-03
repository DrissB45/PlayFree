<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Symfony\Component\Filesystem\Filesystem;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class GenreFixtures extends Fixture
{
    private Filesystem $filesystem;

    public const GENRES = [
        'Action',
        'Aventure',
        'FPS',
        'Combat',
        'Plateforme'
    ];

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



        foreach (self::GENRES as $genreTitle) {
            $genre = new Genre();
            $genre->setTitle($genreTitle);
            $genre->setImage('');
            $manager->persist($genre);
        }

        $manager->flush();
    }
}
