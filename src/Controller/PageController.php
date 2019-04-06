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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{

    /**
     * @Route("/pages/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function getPages(Request $request, $id)
    {

        $page = new Page();
        $page->setId($id);
        $page->setTitle('First');
        $page->setContent('Sample content');


        $pages = [];
        array_push($pages, $page);

        return $this->render('page.html.twig',[
          'pages' => $pages,
          'page' => self::getPageById($id)
        ]);
    }

    /**
     * @Route("/create/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setPages(Request $request, $id)
    {
        return $this->render('base.html.twig');
    }

    /**
     * @Route("/delete/{id}")
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function deletePage(Request $request, $id)
    {
        return $this->render('base.html.twig');
    }

    private function getPageById($id)
    {
        return null;
    }
}