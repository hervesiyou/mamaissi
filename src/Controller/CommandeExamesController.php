<?php

namespace App\Controller;

use App\Entity\CommandeExames;
use App\Form\CommandeExamesForm;
use App\Repository\CommandeExamesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande/exames')]
final class CommandeExamesController extends AbstractController
{
    #[Route(name: 'app_commande_exames_index', methods: ['GET'])]
    public function index(CommandeExamesRepository $commandeExamesRepository): Response
    {
        return $this->render('commande_exames/index.html.twig', [
            'commande_exames' => $commandeExamesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_commande_exames_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commandeExame = new CommandeExames();
        $form = $this->createForm(CommandeExamesForm::class, $commandeExame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commandeExame);
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_exames_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_exames/new.html.twig', [
            'commande_exame' => $commandeExame,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_exames_show', methods: ['GET'])]
    public function show(CommandeExames $commandeExame): Response
    {
        return $this->render('commande_exames/show.html.twig', [
            'commande_exame' => $commandeExame,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_commande_exames_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CommandeExames $commandeExame, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeExamesForm::class, $commandeExame);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_commande_exames_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande_exames/edit.html.twig', [
            'commande_exame' => $commandeExame,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_commande_exames_delete', methods: ['POST'])]
    public function delete(Request $request, CommandeExames $commandeExame, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commandeExame->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($commandeExame);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_exames_index', [], Response::HTTP_SEE_OTHER);
    }
}
