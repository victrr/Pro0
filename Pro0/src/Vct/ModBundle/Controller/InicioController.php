<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Vct\ModBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
/**
* @param $request
* @return $lastUsername $error path VctModBundle:Inicio:index.html.twig
* carga la pantalla de inicio para la autenticacion al modulo cero
*/
class InicioController extends Controller
{
    public function indexAction(Request $request)
    {
    	$authenticationUtils = $this->get('security.authentication_utils');
    	// obtiene un error del login si hubiera uno
        $error = $authenticationUtils->getLastAuthenticationError();
        // ultimo dato ingresado por el usuario
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('VctModBundle:Inicio:index.html.twig', array('last_username' => $lastUsername, 'error' => $error));
    }

    
}
