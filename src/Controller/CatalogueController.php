<?php

namespace App\Controller;

use GMP;
use LDAP\Result;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Service\InsertInDatabase;
use App\Repository\GameRepository;
use App\Repository\GenreRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/catalogue', name: 'catalogue_')]
class CatalogueController extends AbstractController
{
    public function __construct(private InsertInDatabase $insertInDatabase)
    {
        $this->insertInDatabase = $insertInDatabase;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('catalogue/index.html.twig', [
            'games' => $this->insertInDatabase->recordGames()
        ]);
    }

    #[Route('/{id}/voir', name: 'show')]
    public function showGame(Game $game): Response
    {
        return $this->render('catalogue/show.html.twig', [
            'game' => $game
        ]);
    }

    #[Route('/{id}/reserver/', name: 'book')]
    public function bookGame(Game $game, Request $request, GameRepository $gameRepository, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $gamer = $this->getUser();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setGamer($gamer);
            $reservation->setGame($game);
            $game->setIsReserved(true);
            $reservationRepository->save($reservation, true);
            $gameRepository->save($game, true);

            return $this->redirectToRoute('catalogue_show', ['id' => $game->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('catalogue/booking.html.twig', [
            'game' => $game,
            'form' => $form
        ]);
    }

    #[Route('/genres', name: 'genres')]
    public function genreIndex(GenreRepository $genreRepository): Response
    {
        $genres = $genreRepository->findAll();

        return $this->render('catalogue/genres.html.twig', [
            'genres' => $genres
        ]);
    }

    #[Route('/genres/{id}', name: 'genres_show')]
    public function genreShow(Genre $genre, GameRepository $gameRepository): Response
    {
        $games = $gameRepository->findBy(['genre' => $genre->getTitle()]);
        
        return $this->render('catalogue/voirpargenres.html.twig', [
            'games' => $games,
            'genre' => $genre
        ]);
    }

}
