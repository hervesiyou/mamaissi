<?php

namespace App\Controller;

use App\Entity\Entretiens;
use App\Form\EntretiensForm;
use App\Repository\EntretiensRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/entretiens')]
final class EntretiensController extends AbstractController
{
    #[Route(name: 'app_entretiens_index', methods: ['GET'])]
    public function index(EntretiensRepository $entretiensRepository): Response
    {
        return $this->render('entretiens/index.html.twig', [
            'entretiens' => $entretiensRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_entretiens_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretien = new Entretiens();
        $form = $this->createForm(EntretiensForm::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entretien);
            $entityManager->flush();

            return $this->redirectToRoute('app_entretiens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretiens/new.html.twig', [
            'entretien' => $entretien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entretiens_show', methods: ['GET'])]
    public function show(Entretiens $entretien): Response
    {
        return $this->render('entretiens/show.html.twig', [
            'entretien' => $entretien,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_entretiens_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Entretiens $entretien, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntretiensForm::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entretiens_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entretiens/edit.html.twig', [
            'entretien' => $entretien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_entretiens_delete', methods: ['POST'])]
    public function delete(Request $request, Entretiens $entretien, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entretien->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($entretien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_entretiens_index', [], Response::HTTP_SEE_OTHER);
    }
}
