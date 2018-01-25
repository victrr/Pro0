<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
* Clase usada para el manejo de Login
* @author  VHAG
* 
*/
class LoginController extends Controller
{
    /**
    * @param $request
    * @return path VctModBundle:Modulo:modulo.html.twig
    * Realiza las peticiones en el manejo de Login
    */
	public function indexAction(Request $request)
    {
        if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'ROLE_SUPER_ADMIN' ))  
        {   
            $this->addFlash('alert','Este usuario no tiene los priveligios');
            return $this->redirectToRoute('vct_mod_index');
            
        }
        // Valida si la autencacion es correcta
    	if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'IS_AUTHENTICATED_FULLY' ))  
        { 
            throw  $this -> createAccessDeniedException (); 
        }
        // retorna a la pantalla de inicio
        return $this->render('VctModBundle:Modulo:modulo.html.twig');
    }
    // R
    public function loginCheckAction()
    {
            
    }
}
