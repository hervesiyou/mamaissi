<?php

namespace App\Controller;

use App\Entity\Programmes;
use App\Form\ProgrammesForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/programmes')]
final class ProgrammesController extends AbstractController
{
    #[Route(name: 'app_programmes_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $programmes = $entityManager
            ->getRepository(Programmes::class)
            ->findAll();

        return $this->render('programmes/index.html.twig', [
            'programmes' => $programmes,
        ]);
    }

    #[Route('/new', name: 'app_programmes_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $programme = new Programmes();
        $form = $this->createForm(ProgrammesForm::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($programme);
            $entityManager->flush();

            return $this->redirectToRoute('app_programmes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programmes/new.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programmes_show', methods: ['GET'])]
    public function show(Programmes $programme): Response
    {
        return $this->render('programmes/show.html.twig', [
            'programme' => $programme,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_programmes_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Programmes $programme, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProgrammesForm::class, $programme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_programmes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('programmes/edit.html.twig', [
            'programme' => $programme,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_programmes_delete', methods: ['POST'])]
    public function delete(Request $request, Programmes $programme, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$programme->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($programme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_programmes_index', [], Response::HTTP_SEE_OTHER);
    }
}
