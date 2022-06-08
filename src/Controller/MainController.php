<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VideoRepository;
use App\Repository\CinemaRepository;

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
}
