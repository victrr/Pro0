<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vct\ModBundle\Entity\User;
class InicioController extends Controller
{
    public function indexAction(Request $request)
    {
    	$authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('VctModBundle:Inicio:index.html.twig', array('last_username' => $lastUsername, 'error' => $error));
    }

    
}
