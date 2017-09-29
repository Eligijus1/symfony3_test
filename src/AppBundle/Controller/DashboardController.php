<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->render('AppBundle:Dashboard:index.html.twig', array(
            'users' => 1,
        ));
    }
}
