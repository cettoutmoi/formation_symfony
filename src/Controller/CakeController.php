<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Form\CakeType;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CakeController extends AbstractController
{
    private $pdo;

    public function list(CakeRepository $cakeRepository)
    {
        

        return $this->render('cake/list.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);
    }

    public function show(CakeRepository $cakeRepository,$cakeId)
    {
        $cake = $cakeRepository->find($cakeId);
        if (!$cake) {
            throw $this->createNotFoundException(sprintf('The cake with id "%s" was not found.', $cakeId));
        }

        $categories = $cake->getCategories();

        return $this->render('cake/show.html.twig', [
            'cake'  => $cake,
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        $form = $this->createForm(CakeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager(); 
            $cake=$form->getData();
    
            $em->persist($cake);
            $em->flush();

            $this->addFlash('success', 'The cake has been created');

            return $this->redirectToRoute('app_cake_list'); 
        }

        return $this->render('cake/create.html.twig', ['form' => $form->createView()],);
    }

    public function edit(Request $request,CakeRepository $cakeRepository,$cakeId)
    {
        $cake = $cakeRepository->find($cakeId);
        if (!$cake) {
            throw $this->createNotFoundException(sprintf('The cake with id "%s" was not found.', $cakeId));
        }

        $form = $this->createForm(CakeType::class,$cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager(); 
            $cake=$form->getData();
    
            //$em->persist($cake);
            $em->flush();

            $this->addFlash('success', 'The cake has been created');

            return $this->redirectToRoute('app_cake_list'); 
        }

        return $this->render('cake/create.html.twig', ['form' => $form->createView()],);
    }

}