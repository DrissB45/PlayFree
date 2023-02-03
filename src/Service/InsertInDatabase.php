<?php

namespace App\Service;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class InsertInDatabase
{
    private const API_KEY = 'b4c2c261dfdf4eb9a4ee35f459bc938b';

    private GameRepository $gameRepository;

    public function __construct(private HttpClientInterface $client, GameRepository $gameRepository)
    {
        $this->client = $client;
        $this->gameRepository = $gameRepository;
    }

    public function recordGames()
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games?key=' . self::API_KEY
        );

        $dataGames = $response->toArray()['results'];

        foreach ($dataGames as $dataGame) {
            $game = new Game();
            $game->setTitle($dataGame['name']);
            $game->setImage($dataGame['background_image']);
            $game->setGenre($dataGame['genres'][0]['name']);
            $game->setMetacritic($dataGame['metacritic']);
            $game->setSortie($dataGame['released']);
            $game->setIsReserved(false);
            $this->gameRepository->save($game, true);
        }
        
        return $this->gameRepository->findAll();
    }

 /*    public function getGenre()
    {
        $response = $this->client->request(
            'GET',
            'https://api.rawg.io/api/games?key=' . self::API_KEY
        );

        $dataGames = $response->toArray()['results'];

        foreach ($dataGames as $dataGame) {
            $genre = $dataGame['genres'][0]['name']
        }
        
        return $this->gameRepository->findAll();
    } */

}
