<?php
/**
 * Created by PhpStorm.
 * User: kshama
 * Date: 4/6/19
 * Time: 3:39 PM
 */

namespace App\Controller;

use App\Entity\Page;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{

    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @Route("/")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function login(Request $request)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
          ->add('userName', TextType::class, ['required' => true])
          ->add('password', PasswordType::class, ['required' => true])
          ->add('save', SubmitType::class,[
            'label' => 'Login',
              'attr' => ['class' => 'buttonLogin']
          ])
          ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $user = $form->getData();

            if($user->getUserName() === $user->getPassword()) {
                $this->newLogin();
                return $this->redirectToRoute('app_page_getpages', [
                  'id' => 1
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

    private function newLogin() {
        $pages = [];
        $n = 3;
        for ($i = 1; $i <= $n; $i++) {
            $page = new Page($i, 'Title '.$i, 'Content '.$i);
            $pages[$i] = $page;
        }
        $this->session->set('pages', $pages);
        $this->session->set('lastId', $n);
    }

}