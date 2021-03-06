<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $dish = new Dish();

        //form
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ( $form->isSubmitted()){
            //Entity Manager
            $entityManager = $doctrine->getManager();
            $img = $request->files->get('dish')['attachment'];

            //check if there is an image if -> generate a unique name for each upload (in case images with the same file name are uploaded
            if ($img){
                $filename = md5(uniqid()). '.' . $img->guessExtension();
            }

            $img->move(
                $this->getParameter('images_folder'),
                $filename
            );

            $dish->setImage($filename);
            $entityManager->persist($dish);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('dish.edit'));
        }


        return $this->render('dish/createForm.html.twig', [
            'createForm' => $form->createView(),
        ]);
    }

    #[Route('/remove{id}', name: 'remove')]
    public function remove($id, DishRepository $dsh, ManagerRegistry $doctrine ): Response
    {
        $entityManager = $doctrine->getManager();
        // find() returns an object instead of an array like with findAll()
        $dish = $dsh->find($id);
        $entityManager->remove($dish);
        $entityManager->flush();

        //message
        $this->addFlash('succes', 'Dish was removed successfully');

        return $this->redirect($this->generateUrl('dish.edit'));
    }

    //@paramConverter: $request are converted in to objects
    #[Route('/show{id}', name: 'show')]
    public function show(Dish $dish) : Response
    {

        return $this->render('dish/showDish.html.twig', [
            'dish' => $dish,
        ]);
    }
}
