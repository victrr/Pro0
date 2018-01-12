<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
	public function indexAction(Request $request)
    {
    	if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'IS_AUTHENTICATED_FULLY' ))  
        { 
            throw  $this -> createAccessDeniedException (); 
        }
        return $this->render('VctModBundle:Modulo:modulo.html.twig');
    }

    public function loginCheckAction()
    {
            
    }
}
