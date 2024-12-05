<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProductType;
use Symfony\component\HttpKernel\Exception\AccessDeniedHttpException;

#[Route('/product')]
class ProductController extends AbstractController
{
   
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'produies' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        
        // Autorisé uniquement pour les administrateurs
        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $product = new product();
        $form = $this->createForm(productType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();    

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }
    
    #[Route('/{id}', name: 'app_product_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, product $product, EntityManagerInterface $entityManager): Response
    {
        // Autorisé uniquement pour les administrateurs
        $this->denyAccessUnlessGranted('ROLE_MANAGER');


        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {

        // Autorisé uniquement pour les administrateurs
        $this->denyAccessUnlessGranted('ROLE_MANAGER');


        $form = $this->createForm(ProductType::class, $product);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
           
            $product->updateTimestamp();
    
           
            $entityManager->flush();
    
            return $this->redirectToRoute('app_product_show', ['id' => $product->getId()]);
        }
    
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    
    
}
