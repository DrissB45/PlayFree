<?php

namespace App\Controller;

use App\Entity\Game;
use App\Entity\Reservation;
use App\Repository\GameRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/reservations', name: 'reservations_')]
class BookingController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function bookings(ReservationRepository $reservationRepository): Response
    {
        $reservation = $reservationRepository->findOneBy(['gamer' => $this->getUser()]);

        return $this->render('catalogue/voirbooking.html.twig', [
            'reservation' => $reservation
        ]);
    }
}
