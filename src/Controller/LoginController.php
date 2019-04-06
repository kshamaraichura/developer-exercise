<?php
/**
 * Created by PhpStorm.
 * User: kshama
 * Date: 4/6/19
 * Time: 3:39 PM
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{

    /**
     * @Route("/")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function login(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
          ->add('userName', TextType::class)
          ->add('password', PasswordType::class)
          ->add('save', SubmitType::class,[
            'label' => 'Login'
          ])
          ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $user = $form->getData();

            if($user->getUserName() === $user->getPassword()) {
                return $this->redirectToRoute('app_page_getpages', [
                  'id' => 0
                ]);
            } else {
                return $this->render('login.html.twig', [
                  "form" => $form->createView(),
                      "error" => "error"
                    ]
                );
            }
        }

        return $this->render('login.html.twig', [
          "form" => $form->createView()
        ]);
    }

}