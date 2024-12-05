<?php

namespace App\Controller;

use App\Entity\Veterinary;
use App\Form\VeterinaryType;
use App\Repository\VeterinaryRepository;
use App\Repository\FollowUpRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ActivitySelectType;
use App\Form\CategorySelectType;
use App\Entity\Activity;
use App\Entity\Category;

#[Route('/veterinary')]
class VeterinaryController extends AbstractController
{
    #[Route('/', name: 'app_veterinary_index', methods: ['GET'])]
    public function index(VeterinaryRepository $veterinaryRepository): Response
    {
        return $this->render('veterinary/index.html.twig', [
            'veterinaries' => $veterinaryRepository->findAll(),
        ]);
    }

    #[Route('/{id}/followups', name: 'app_veterinary_suivis', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show_suivis(Veterinary $veterinary, FollowUpRepository $followUpRepository): Response
    {
        $follow_Ups = $followUpRepository->findBy(['veterinary' => $veterinary]);

        return $this->render('veterinary/followups.html.twig', [
            'veterinary' => $veterinary,
            'followUps' => $follow_Ups,
        ]);
    }


    #[Route('/new', name: 'app_veterinary_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $veterinary = new Veterinary();
        $form = $this->createForm(VeterinaryType::class, $veterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($veterinary);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/new.html.twig', [
            'veterinary' => $veterinary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinary_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Veterinary $veterinary): Response
    {
        return $this->render('veterinary/show.html.twig', [
            'veterinary' => $veterinary,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_veterinary_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaryType::class, $veterinary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary/edit.html.twig', [
            'veterinary' => $veterinary,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinary_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Veterinary $veterinary, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $veterinary->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($veterinary);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veterinary_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/dashboard/indicators', name: 'app_dashboard_indicators')]
    public function indicators(VeterinaryRepository $veterinaryRepository): Response
    {
        $nbNouveauxVetosDuMois = $veterinaryRepository->countNewVetsInMonth();
        $nbVetos = $veterinaryRepository->countAllVets();
        return $this->render('dashboard/indicators.html.twig', [
            'newVetsNumber' => $nbNouveauxVetosDuMois,
            'vetsNumber' => $nbVetos,

        ]);
    }
    #[Route('/ search_by_activity ', name: 'app_search_by_activity', methods: ['GET', 'POST'])]
    public function searchByActivity(Request $request, VeterinaryRepository $veterinaryRepository): Response
    {
        // Par défaut, la liste des vétérinaires contient tous les vétérinaires
        $veterinaries = $veterinaryRepository->findAll();
        // On crée un objet Activity pour interagir avec le formulaire
        $activity = new Activity();
        // On crée un formulaire basé sur la classe formulaire créée précédemment
        $form = $this->createForm(ActivitySelectType::class);
        // Récupère les données dans la superglobale adéquate ($_POST ou $_GET)
        $form->handleRequest($request);
        // Le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données du formulaire
            $data = $form->getData();

            $activity = $data['activity'];
            // Si une catégorie est sélectionnée, on récupère la liste des vétérinaires concernés
            if (!is_null($activity)) {
                $veterinaries = $veterinaryRepository->findByActivity($activity);
            }
        }
        return $this->render('veterinary/search_by_activity.html.twig', [
            'veterinaries' => $veterinaries,
            'form' => $form,
        ]);
    }

    #[Route('/search_by_category', name: 'app_search_by_category', methods: ['GET', 'POST'])]
    public function searchByCategory(Request $request, VeterinaryRepository $veterinaryRepository): Response
    {
        // Par défaut, la liste des vétérinaires contient tous les vétérinaires
        $veterinaries = $veterinaryRepository->findAll();
        // On crée un objet Activity pour interagir avec le formulaire
        $category = new Category();
        // On crée un formulaire basé sur la classe formulaire créée précédemment
        $form = $this->createForm(CategorySelectType::class);
        // Récupère les données dans la superglobale adéquate ($_POST ou $_GET)
        $form->handleRequest($request);
        // Le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données du formulaire
            $data = $form->getData();

            $category = $data['category'];
            // Si une catégorie est sélectionnée, on récupère la liste des vétérinaires concernés
            if (!is_null($category)) {
                $veterinaries = $veterinaryRepository->findByCategory($category);
            }
        }
        return $this->render('veterinary/search_by_category.html.twig', [
            'veterinaries' => $veterinaries,
            'form' => $form,
        ]);
    }
 
}
