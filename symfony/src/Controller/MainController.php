<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/main', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/start/{name?}', name: 'app_start')]
    public function start (Request $request, $name): Response
    {
        $randomNumber = random_int(0,100);
        return new Response('<h1>hallowkes ' . $name .  ' your number is ' . $randomNumber. '</h1>');
    }
}
