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

/**
* Clase usada para el modulo cero.
* @author  VHAG
* 
*/

class ModuloController extends Controller
{
    /**
    * @param $request
    * @return $users $session path VctModBundle:Modulo:modulo.html.twig
    * Genera la consulta de datos Persona y Telefonos redirecciona a la pantalla Modulo_Cero
    */
    public function indexAction(Request $request)
    {   
        // Verifica si exuiste un usuario auterntificado
    	if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'ROLE_SUPER_ADMIN' ))  
        {   
            $this->addFlash('alert','Este usuario no tiene los priveligios');
            return $this->redirectToRoute('vct_mod_index');
            
        }
        $persona = new Persona();
        // Se crea la instancia ResultSetMapping
        $rsm = new ResultSetMapping();
        //se obtiene la sesion 
        $sessions =  $this -> getUser ();
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();
        
        // Consulta de Personas y telefonos en BD 
        $sql =  "SELECT p.id AS id,p.nombre AS nombre, p.apPaterno AS apPaterno, p.apMaterno AS apMaterno, 
                MAX(if(t.tipo='Celular',t.telefono,'')) AS tipoCel, 
                MAX(if(t.tipo='Casa',t.telefono,'')) AS tipoCasa, 
                MAX(if(t.tipo='Trabajo',t.telefono,'')) AS tipoTrabajo,
                MAX(p.created_at) AS fe_creado,
                MAX(p.updated_at) AS fe_actualizado
                FROM personas p JOIN telefonos t
                WHERE p.id = t.person_id
                GROUP BY p.id,p.nombre,p.id
                ORDER BY p.id";
        // se inicia la peticion a BD
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $persons = $stmt->fetchAll();
        // Se obtiene los datos del usuario en sesion 
        $session = $em->getRepository('VctModBundle:Persona')->findOneById($sessions);   
        $form = $this->createCreateForm($persona);             
        return $this->render('VctModBundle:Modulo:modulo.html.twig', array('persons' => $persons, 'session' => $session, 'form' => $form->createView()));
    }

    public function createCreateForm(Persona $entity){
        $form = $this->createForm(new PersonaType(), $entity, array('action' => $this->generateUrl('vct_modulo_add'),'method' =>'POST' ));
    
        return $form;
    }

    /**
    * @param $request
    * @return $response
    * Agrega los registros en formulario enviados desde la pantalla modulo cero 
    */
    public function addAction(Request $request)
    {   
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();
        // se obtiene la entidad Persona
        $personas = $em->getRepository('VctModBundle:Persona');
        
        // Carga de los datos enviados desde el formulario
        $nombre=$request->request->get('nombre');
        $apPaterno=$request->request->get('apPaterno');
        $apMaterno=$request->request->get('apMaterno');
        $telcelu=$request->request->get('telcelu');
        $telcas=$request->request->get('telcas');
        $teltrab=$request->request->get('teltrab');
        $telval1=$request->request->get('telCl');
        $telval2=$request->request->get('telC');
        $telval3=$request->request->get('telTr');
        
        // Se crea la instancia Persona y se cargan los datos del formulario
        $persona = new Persona();
        // seteo de los datos para la entidad Persona
        $persona->setNombre($nombre);
        $persona->setapPaterno($apPaterno);
        $persona->setapMaterno($apMaterno);
        
        /**
        * Se crean  validaciones para insertar los telefonos del tipo: Celular,casa y Trabajo.
        */
        // Valida si el dato de celular es nulo
        if ($telcelu !== null)
        {
            $telf = new Telefono();
            $telf->setTelefono($telcelu);
            $telf->setTipo($telval1);
            $telf->setPerson($persona);
            $em->persist($telf);
        }
        // Valida si el dato de casa es nulo
        if ($telcas !== null)
        {
            $telf = new Telefono();
            $telf->setTelefono($telcas);
            $telf->setTipo($telval2);
            $telf->setPerson($persona);
            $em->persist($telf);
        }
        // Valida si el dato de trabajo es nulo
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
 
        // Ejecuta el Insert
        $em->flush();
        // codigo de retorno por medio de AJAX
        $cod = '0001';
        //Se genera el response
        $response = new Response(json_encode(array('code' => $cod)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;        
    }

    /**
    * @param $request
    * @return $persona, $form path VctModBundle:Modulo:edit.html.twig
    * Regresa el formulario Persona
    */
    public function editAction($id)
    {
        if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'ROLE_SUPER_ADMIN' ))  
        {   
            $this->addFlash('alert','Este usuario no tiene los priveligios');
            return $this->redirectToRoute('vct_mod_index');
            
        }
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();
        // se obtiene la entidad Persona
        $persona = $em->getRepository('VctModBundle:Persona')->find($id);
        // valida si la respuesta es false
        if(!$persona)
        {
             throw $this->createNotFoundException('Persona Not Found');
        }
        //Llamada al metodo de la creacion del formulario persona
        $form = $this->createEditForm($persona);
        return $this->render('VctModBundle:Modulo:edit.html.twig', array('persona' => $persona, 'form' => $form->createView()));
        
    }
    
    /**
    * @param $entity
    * @return $form
    * Creacion del formulario Persona
    */
    public function createEditForm(Persona $entity)
    {
        // se establece la creacion del formulario Persona
        $form = $this->createForm(new PersonaType(), $entity, array('action' => $this->generateUrl('vct_modulo_update', array('id' => $entity->getId() )),'method' =>'PUT' ));
        
        return $form;
    }
    
    /**
    * @param $id, $request
    * @return $persona, $form path VctModBundle:Modulo:edit.html.twig
    * Actualiza los datos del fomulario persona 
    */
    public function updateAction($id, Request $request)
    {
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();
        // Se obtiene la entidad Persona
        $persona = $em->getRepository('VctModBundle:Persona')->find($id);
        // valida si la respuesta es false
        if(!$persona)
        {
             throw $this->createNotFoundException('Persona Not Found');
        }
        //Llamada al metodo de la creacion del formulario persona
        $form = $this->createEditForm($persona);
        //Recibe la peticion de los datos en el formulario
        $form->handleRequest($request);
        // Valida si los datos en el formulario han sido enviados y son correctos.
        if($form->isSubmitted() and $form->isValid())
        {            
        // General el update a la BD            
            $em->flush();
            // Mensaje de exito mostrado en pantalla
            $this->addFlash('success','Se han guardado los cambios.');            
            // retorna el formulario persona con la nueva actualizacion
            return $this->redirectToRoute('vct_modulo_edit', array('id' => $persona->getId()));
        }
        // retorna el formulario persona
        return $this->render('VctModBundle:Modulo:edit.html.twig', array('persona' => $persona, 'form' => $form->createView() ));
    }

    /**
    * @param $id, $request
    * @return $persons path VctModBundle:Modulo:ver.html.twig
    * Realiza la vista de detalles de persona
    */
    public function viewAction($id)
    {   
        if  ( !$this -> get ( 'security.authorization_checker' ) -> isGranted ( 'ROLE_SUPER_ADMIN' ))  
        {   
            $this->addFlash('alert','Este usuario no tiene los priveligios');
            return $this->redirectToRoute('vct_mod_index');
            
        }
        // Se obtiene la sesion 
        $sessions =  $this -> getUser ();
        // Se recupera EntityManager
        $em = $this->getDoctrine()->getManager();
        // Consulta de Personas y telefonos en BD por id de persona.
        $sql =  "SELECT p.id AS id,p.nombre AS nombre, p.apPaterno AS apPaterno, p.apMaterno AS apMaterno, 
                MAX(if(t.tipo='Celular',t.telefono,'')) AS tipoCel, 
                MAX(if(t.tipo='Casa',t.telefono,'')) AS tipoCasa, 
                MAX(if(t.tipo='Trabajo',t.telefono,'')) AS tipoTrabajo,
                MAX(p.created_at) AS fe_creado,
                MAX(p.updated_at) AS fe_actualizado
                FROM personas p JOIN telefonos t
                WHERE p.id = t.person_id
                  AND p.id= :id_person
                GROUP BY p.id,p.nombre,p.id
                ORDER BY p.id";
        // se inicia la peticion a BD
        $conn = $em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id_person' => $id]);
        $persons = $stmt->fetchAll();   
        
        return $this->render('VctModBundle:Modulo:ver.html.twig', array('persons' => $persons));
    }
}
