<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
    public function index(): Response
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
        $games = $response->toArray()['results'];
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
       /*  var_dump($games); exit(); */

        return $this->render('catalogue/index.html.twig', [
            'games' => $games
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
