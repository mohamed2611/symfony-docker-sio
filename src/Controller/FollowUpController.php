<?php

namespace App\Controller;

use App\Entity\FollowUp;
use App\Form\FollowUpType;
use App\Repository\FollowUpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/follow/up')]
class FollowUpController extends AbstractController
{
    #[Route('/', name: 'app_follow_up_index', methods: ['GET'])]
    public function index(FollowUpRepository $followUpRepository): Response
    {
        // Trier par date d'appel décroissante
        $followUps = $followUpRepository->findBy([], ['callDate' => 'DESC']);

        return $this->render('follow_up/index.html.twig', [
            'follow_ups' => $followUps,
        ]);
    }


    #[Route('/new', name: 'app_follow_up_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $followUp = new FollowUp();
        $form = $this->createForm(FollowUpType::class, $followUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($followUp);
            $entityManager->flush();

            return $this->redirectToRoute('app_follow_up_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('follow_up/new.html.twig', [
            'follow_up' => $followUp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_follow_up_show', methods: ['GET'])]
    public function show(FollowUp $followUp): Response
    {
        return $this->render('follow_up/show.html.twig', [
            'follow_up' => $followUp,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_follow_up_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FollowUp $followUp, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FollowUpType::class, $followUp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_follow_up_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('follow_up/edit.html.twig', [
            'follow_up' => $followUp,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_follow_up_delete', methods: ['POST'])]
    public function delete(Request $request, FollowUp $followUp, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $followUp->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($followUp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_follow_up_index', [], Response::HTTP_SEE_OTHER);
    }
}
