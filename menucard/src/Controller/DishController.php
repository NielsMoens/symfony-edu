<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/dish', name: 'dish.')]
class DishController extends AbstractController
{
    #[Route('/', name: 'edit')]
    public function index(DishRepository $dsh): Response
    {
        $dishes= $dsh->findAll();

        return $this->render('dish/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(ManagerRegistry $doctrine): Response
    {
        //form
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);

        $entityManager = $doctrine->getManager();
//        $entityManager->persist($dish);
//        $entityManager->flush();

        return $this->render('dish/createForm.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }
}
