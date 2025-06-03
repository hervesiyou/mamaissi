<?php

namespace App\Controller;

use App\Entity\Examens;
use App\Form\ExamensForm;
use App\Repository\ExamensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/examens')]
final class ExamensController extends AbstractController
{
    #[Route(name: 'app_examens_index', methods: ['GET'])]
    public function index(ExamensRepository $examensRepository): Response
    {
        return $this->render('examens/index.html.twig', [
            'examens' => $examensRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_examens_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $examen = new Examens();
        $form = $this->createForm(ExamensForm::class, $examen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($examen);
            $entityManager->flush();

            return $this->redirectToRoute('app_examens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examens/new.html.twig', [
            'examen' => $examen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_examens_show', methods: ['GET'])]
    public function show(Examens $examen): Response
    {
        return $this->render('examens/show.html.twig', [
            'examen' => $examen,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_examens_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Examens $examen, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExamensForm::class, $examen);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_examens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examens/edit.html.twig', [
            'examen' => $examen,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_examens_delete', methods: ['POST'])]
    public function delete(Request $request, Examens $examen, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$examen->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($examen);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_examens_index', [], Response::HTTP_SEE_OTHER);
    }
}
