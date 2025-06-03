<?php

namespace App\Controller;

use App\Entity\Patients;
use App\Form\PatientsForm;
use App\Repository\PatientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/patients')]
final class PatientsController extends AbstractController
{
    #[Route(name: 'app_patients_index', methods: ['GET'])]
    public function index(PatientsRepository $patientsRepository): Response
    {
        return $this->render('patients/index.html.twig', [
            'patients' => $patientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_patients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $patient = new Patients();
        $form = $this->createForm(PatientsForm::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patients/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patients_show', methods: ['GET'])]
    public function show(Patients $patient): Response
    {
        return $this->render('patients/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_patients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Patients $patient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PatientsForm::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patients/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patients_delete', methods: ['POST'])]
    public function delete(Request $request, Patients $patient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$patient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patients_index', [], Response::HTTP_SEE_OTHER);
    }
}
