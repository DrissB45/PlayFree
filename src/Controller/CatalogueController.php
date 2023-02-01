<?php

namespace App\Controller;

use GMP;
use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/catalogue', name: 'catalogue_')]
class CatalogueController extends AbstractController
{
    private const API_KEY = 'b4c2c261dfdf4eb9a4ee35f459bc938b';

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/', name: 'index')]
    public function index(GameRepository $gameRepository): Response
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games?key=' . self::API_KEY
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $dataGames = $response->toArray()['results'];
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        
        foreach ($dataGames as $dataGame) {
            $game = new Game();
            $game->setTitle($dataGame['name']);
            $game->setImage($dataGame['background_image']);
            $game->setGenre($dataGame['genres'][0]['name']);
            $gameRepository->save($game, true);
        }


        return $this->render('catalogue/index.html.twig', [
            'games' => $dataGames
        ]);
    }

    #[Route('/consoles', name: 'consoles')]
    public function consoles(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/platforms?key=' . self::API_KEY
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray()['results'];
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        /* var_dump($content); exit(); */

        return $this->render('catalogue/index.html.twig', [
            'content' => $content
        ]);
    }
}
