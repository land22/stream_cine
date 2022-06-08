<?php

namespace App\Controller;

use App\Entity\Cinema;
use App\Form\CinemaType;
use App\Repository\CinemaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_SUPER_ADMIN")
 */
#[Route('/cinema')]
class CinemaController extends AbstractController
{
    #[Route('/', name: 'app_cinema_index', methods: ['GET'])]
    public function index(CinemaRepository $cinemaRepository): Response
    {
        return $this->render('cinema/index.html.twig', [
            'cinemas' => $cinemaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cinema_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CinemaRepository $cinemaRepository, FileUploader $fileUploader): Response
    {
        $cinema = new Cinema();
        $form = $this->createForm(CinemaType::class, $cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $imageFileName = $fileUploader->upload($imageFile);
            $cinema->setImage($imageFileName);
        }
        $cinema->setUser($this->getUser());
            $cinemaRepository->add($cinema, true);

            return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cinema/new.html.twig', [
            'cinema' => $cinema,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cinema_show', methods: ['GET'])]
    public function show(Cinema $cinema): Response
    {
        return $this->render('cinema/show.html.twig', [
            'cinema' => $cinema,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cinema_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cinema $cinema, CinemaRepository $cinemaRepository): Response
    {
        $form = $this->createForm(CinemaType::class, $cinema);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cinemaRepository->add($cinema, true);

            return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cinema/edit.html.twig', [
            'cinema' => $cinema,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cinema_delete', methods: ['POST'])]
    public function delete(Request $request, Cinema $cinema, CinemaRepository $cinemaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cinema->getId(), $request->request->get('_token'))) {
            $cinemaRepository->remove($cinema, true);
        }

        return $this->redirectToRoute('app_cinema_index', [], Response::HTTP_SEE_OTHER);
    }
}
