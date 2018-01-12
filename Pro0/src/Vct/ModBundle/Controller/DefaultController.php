<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VctModBundle:Default:index.html.twig');
    }
}
