<?php

namespace Test1Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('Test1Bundle:Default:index.html.twig',
            array(
                'title'       => "title",
                'page_title'  => "page_title",
                'status_code' => "status_code"
            ));
    }
}
