<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Veterinary;
use App\Repository\VeterinaryRepository;

class DashboardController extends AbstractController
{
    #[Route('/dashboard/followups', name: 'app_dashboard_followups')]
public function followUpsByVeterinary(VeterinaryRepository $veterinaryRepository): Response
    {
        $suivisParVeto = $veterinaryRepository->getNumberFollowsupByVeterinary();
            dump($suivisParVeto);
            return $this->render('dashboard/followups.html.twig', [
            'followup' => $suivisParVeto,
        ]);
    }

}
