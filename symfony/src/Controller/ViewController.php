<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    #[Route('/view', name: 'app_view')]
    public function index(): Response
    {
        $date = date("l");

        $user = [
            'name' => 'fons',
            'firstname' => 'makker',
            'age' => '99'
        ];

        $a = array('apple', 'peer', 'FONS MAKKER');
        return $this->render('view/index.html.twig', [
            'd' => $date,
            'user'=> $user,
            'a' => $a
        ]);
    }
}
