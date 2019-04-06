<?php
/**
 * Created by PhpStorm.
 * User: kshama
 * Date: 4/6/19
 * Time: 3:43 PM
 */

namespace App\Controller;

use App\Entity\Page;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    protected $session;

    public function __construct()
    {
        $this->session = new Session();
    }

    /**
     * @Route("/pages/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function getPages(Request $request, $id)
    {
        $pages = $this->session->get('pages', []);

        return $this->render('page.html.twig',[
          'pages' => $pages,
          'page' => $this->getPageById($id)
        ]);
    }

    /**
     * @Route("/create/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setPages(Request $request, $id = 0)
    {
        $pages = $this->session->get('pages', []);
        $page = new Page($id, 'Enter title', 'Enter Content');
        if ($id > 0) {
            $page = $this->getPageById($id);
        }

        $form = $this->createFormBuilder($page)
          ->add('title', TextType::class, ['required' => true])
          ->add('content', TextareaType::class, ['required' => true])
          ->add('save', SubmitType::class, [
            'label' => 'Save',
            'attr' => ['class' => 'buttonLogin']
          ])
          ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $pageData = $form->getData();
            $newId = ($id == 0) ? $this->getNextId() : $id;
            $page = new Page($newId, $pageData->getTitle(), $pageData->getContent());
            $pages[$newId] = $page;
            $this->session->set('pages', $pages);
            return $this->getPages($request, $newId);
        }

        return $this->render('page.html.twig', [
            'pages' => $pages,
            'page' => $page,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function deletePage(Request $request, $id)
    {
        $pages = $this->session->get('pages', []);
        if (isset($pages[$id])) {
            unset($pages[$id]);
        }
        $this->session->set('pages', $pages);
        return $this->getPages($request, $id);
    }

    private function getPageById($id)
    {
        $pages = $this->session->get('pages', []);
        return isset($pages[$id]) ? $pages[$id] : null;
    }

    private function getNextId() {
        $lastId = $this->session->get('lastId', 0) + 1;
        $this->session->set('lastId', $lastId);
        return $lastId;
    }
}