<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/reg', name: 'reg')]
    public function reg(Request $request): Response
    {
        $regform = $this->createFormBuilder()
            ->add('username', TextType::class,[
                'label' => 'employee'])
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'required' => true,
                'first_options'=>['label'=> 'Password'],
                'second_options'=>['label'=> 'Repeat Password'],
            ])
            ->add('registration', SubmitType::class)
            ->getForm();

        $regform->handleRequest($request);
        if ($regform->isSubmitted()){
            $input = $regform->getData();
            dump($input);
        }

        return $this->render('registration/index.html.twig', [
            'regform' => $regform->createView()
        ]);
    }
}
