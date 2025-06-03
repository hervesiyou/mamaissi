<?php

namespace App\Controller;

use App\Entity\Consultations;
use App\Form\ConsultationsForm;
use App\Repository\ConsultationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/consultations')]
final class ConsultationsController extends AbstractController
{
    #[Route(name: 'app_consultations_index', methods: ['GET'])]
    public function index(ConsultationsRepository $consultationsRepository): Response
    {
        return $this->render('consultations/index.html.twig', [
            'consultations' => $consultationsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_consultations_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $consultation = new Consultations();
        $form = $this->createForm(ConsultationsForm::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($consultation);
            $entityManager->flush();

            return $this->redirectToRoute('app_consultations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consultations/new.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultations_show', methods: ['GET'])]
    public function show(Consultations $consultation): Response
    {
        return $this->render('consultations/show.html.twig', [
            'consultation' => $consultation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_consultations_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Consultations $consultation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConsultationsForm::class, $consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_consultations_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('consultations/edit.html.twig', [
            'consultation' => $consultation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_consultations_delete', methods: ['POST'])]
    public function delete(Request $request, Consultations $consultation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$consultation->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($consultation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_consultations_index', [], Response::HTTP_SEE_OTHER);
    }
}
