<?php

namespace Vct\ModBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Vct\ModBundle\Entity\User;
use Vct\ModBundle\Entity\Persona;
use Vct\ModBundle\Entity\Telefono;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Vct\ModBundle\Form\PersonaType;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Common\Collections\ArrayCollection;
class ModuloController extends Controller
{
    public function indexAction(Request $request)
    {
    	if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'IS_AUTHENTICATED_FULLY' ))  
        { 
            throw  $this -> createAccessDeniedException (); 
        }

        $sessions =  $this -> getUser ();
        $users = new ArrayCollection();
        $em = $this->getDoctrine()->getManager();
        $rsm = new ResultSetMapping();
        $sql =  "SELECT p.id AS id,p.nombre AS nombre, 
                MAX(if(t.tipo='Celular',t.telefono,'')) AS tipoCel, 
                MAX(if(t.tipo='Casa',t.telefono,'')) AS tipoCasa, 
                MAX(if(t.tipo='Trabajo',t.telefono,'')) AS tipoTrabajo,
                MAX(p.created_at) AS fe_creado,
                MAX(p.updated_at) AS fe_actualizado
                FROM personas p JOIN telefonos t
                WHERE p.id = t.person_id
                GROUP BY p.id,p.nombre,p.id
                ORDER BY p.id";
        $query = $em->createNativeQuery($sql,$rsm);
        $users = $query->getResult();
        
        //$em = $this->getDoctrine()->getManager();
        $session = $em->getRepository('VctModBundle:Persona')->findOneById($sessions);
        //$users = $em->getRepository('VctModBundle:Persona')->findAll();
        return $this->render('VctModBundle:Modulo:modulo.html.twig', array('persons' => $users, 'session' => $session));
    }

    public function addAction(Request $request)
    {   
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();

        $personas = $em->getRepository('VctModBundle:Persona');
        
        $query = $personas->createQueryBuilder('p')
                        ->select('max(p.id)+1 mmayor')
                        ->getQuery();
         
        $max = $query->getSingleScalarResult();
        
        $nombre=$request->request->get('nombre');
        $apPaterno=$request->request->get('apPaterno');
        $apMaterno=$request->request->get('apMaterno');
        $telcelu=$request->request->get('telcelu');
        $telcas=$request->request->get('telcas');
        $teltrab=$request->request->get('teltrab');
        $telval1=$request->request->get('telCl');
        $telval2=$request->request->get('telC');
        $telval3=$request->request->get('telTr');
        /*
            Se crea la instancia Persona y se cargan los datos del formulario
        */
        $persona = new Persona();
        $persona->setNombre($nombre);
        $persona->setapPaterno($apPaterno);
        $persona->setapMaterno($apMaterno);
        
        if ($telcelu !== null)
        {
            $telf = new Telefono();
            $telf->setTelefono($telcelu);
            $telf->setTipo($telval1);
            $telf->setPerson($persona);
            $em->persist($telf);
        }
        if ($telcas !== null)
        {
            $telf = new Telefono();
            $telf->setTelefono($telcas);
            $telf->setTipo($telval2);
            $telf->setPerson($persona);
            $em->persist($telf);
        }
        if ($teltrab !== null)
        {
            $telf = new Telefono();
            $telf->setTelefono($teltrab);
            $telf->setTipo($telval3);
            $telf->setPerson($persona);
            $em->persist($telf);
        }

            // Llamada a Doctrine, guarda el objeto persona
        $em->persist($persona);
 
        // Ejecuta query Insert
        $em->flush();
        

        

        return new Response('Saved new product with max '.$telcelu);

    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $persona = $em->getRepository('VctModBundle:Persona')->find($id);
        
        if(!$persona)
        {
             throw $this->createNotFoundException('Persona Not Found');
        }
        
        $form = $this->createEditForm($persona);
        
        return $this->render('VctModBundle:Modulo:edit.html.twig', array('persona' => $persona, 'form' => $form->createView()));
        
    }
    
    public function createEditForm(Persona $entity)
    {
        $form = $this->createForm(new PersonaType(), $entity, array('action' => $this->generateUrl('vct_modulo_update', array('id' => $entity->getId() )),'method' =>'PUT' ));
        
        return $form;
    }
    
    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $persona = $em->getRepository('VctModBundle:Persona')->find($id);
         
        if(!$persona)
        {
             throw $this->createNotFoundException('Persona Not Found');
        }
        
        $form = $this->createEditForm($persona);
        $form->handleRequest($request);
        
        if($form->isSubmitted() and $form->isValid())
        {
            
            
            $em->flush();
            
            $this->addFlash('success','Se han guardado los cambios.');
            return $this->redirectToRoute('vct_modulo_edit', array('id' => $persona->getId()));
        }
        
        return $this->render('VctModBundle:Modulo:edit.html.twig', array('persona' => $persona, 'form' => $form->createView() ));
    }
}
