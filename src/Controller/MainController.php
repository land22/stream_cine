<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VideoRepository;
use App\Repository\CinemaRepository;
use App\Entity\Video;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommentaireRepository;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ProjectionRepository;
use App\Repository\ReservationRepository;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
        ]);
    }

    #[Route('/main/video', name: 'app_main_video')]
    public function video(VideoRepository $videoRepository): Response
    {
        return $this->render('main/video.html.twig', [
            'videos' => $videoRepository->findAll()
        ]);
    }
    #[Route('/main/cinema', name: 'app_main_cinema')]
    public function cinema(CinemaRepository $cinemaRepository): Response
    {
        return $this->render('main/cinema.html.twig', [
            'cinemas' => $cinemaRepository->findAll()
        ]);
    }
    #[Route('/main/video/details/{id}', name: 'app_main_video_details', methods: ['GET', 'POST'])]
    public function videoDetail(Video $video, Request $request, CommentaireRepository $commentaireRepository): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire->setUser($this->getUser());
            $commentaire->setVideo($video);
            $commentaireRepository->add($commentaire, true);

            return $this->redirectToRoute('app_main_video_details', ['id'=>$video->getId()], Response::HTTP_SEE_OTHER);
            
        }
        return $this->render('main/video_detail.html.twig', [
            'video' => $video,
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/main/reservation/{id}', name: 'app_main_reservation', methods: ['GET', 'POST'])]
    public function cinemaReservation(ProjectionRepository $projectionRepository, ReservationRepository $reservationRepository, int $id): Response
    {
        $projection = $projectionRepository->findOneBy(['video' => $id]);
        $reservation = new Reservation();
            $reservation->setEtat('En cour');
            $reservation->setUser($this->getUser());
            $reservation->setProjection($projection);
            $reservationRepository->add($reservation, true);
            $this->addFlash('noticeReservation', 'Votre reservation ?? ??t?? pris en compte !!!');
            return $this->redirectToRoute('app_main_cinema_details', ['id'=>$projection->getCinema()->getId()], Response::HTTP_SEE_OTHER);
            
    }

    #[Route('/main/cinema/details/{id}', name: 'app_main_cinema_details', methods: ['GET', 'POST'])]
    public function cinemaDetail(ProjectionRepository $projectionRepository, int $id): Response
    {
        $projection = $projectionRepository->findBy(['cinema' => $id]);

        return $this->render('main/cinema_detail.html.twig', [
            'projections' => $projection,
        ]);
    }
    #[Route('/main/contact', name: 'app_main_contact')]
    public function contact(): Response
    {
        
        return $this->render('main/contact.html.twig', [
        ]);
    }
}
