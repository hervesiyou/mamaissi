<?php

namespace App\Controller;

use App\Entity\ExamenPrix;
use App\Form\ExamenPrixForm;
use App\Repository\ExamenPrixRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/examen/prix')]
final class ExamenPrixController extends AbstractController
{
    #[Route(name: 'app_examen_prix_index', methods: ['GET'])]
    public function index(ExamenPrixRepository $examenPrixRepository): Response
    {
        return $this->render('examen_prix/index.html.twig', [
            'examen_prixes' => $examenPrixRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_examen_prix_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $examenPrix = new ExamenPrix();
        $form = $this->createForm(ExamenPrixForm::class, $examenPrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($examenPrix);
            $entityManager->flush();

            return $this->redirectToRoute('app_examen_prix_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examen_prix/new.html.twig', [
            'examen_prix' => $examenPrix,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_examen_prix_show', methods: ['GET'])]
    public function show(ExamenPrix $examenPrix): Response
    {
        return $this->render('examen_prix/show.html.twig', [
            'examen_prix' => $examenPrix,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_examen_prix_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ExamenPrix $examenPrix, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ExamenPrixForm::class, $examenPrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_examen_prix_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examen_prix/edit.html.twig', [
            'examen_prix' => $examenPrix,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_examen_prix_delete', methods: ['POST'])]
    public function delete(Request $request, ExamenPrix $examenPrix, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$examenPrix->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($examenPrix);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_examen_prix_index', [], Response::HTTP_SEE_OTHER);
    }
}
