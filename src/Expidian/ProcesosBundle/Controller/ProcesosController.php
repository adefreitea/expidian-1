<?php

namespace Expidian\ProcesosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Expidian\GlobalBundle\Entity\Usuarios;
use Expidian\GlobalBundle\Entity\Personas;

use Expidian\UsuariosBundle\Controller\Session\SessionManager;

/**
 * Description of UsuariosController
 *
 * @author autana
 */
class ProcesosController extends Controller {
	
	
	public function indexAction()
    {
		$request = $this->getRequest();
        $session = $request->getSession();
                
        $sm = new SessionManager($session);
        $sm->readSession();
        
        if($sm->getSession_is_open()){
            
            $usuario_obj = $sm->getUsuario();
            $breadcrumb = array(array('text'=>'Usuarios','url'=>$this->generateUrl('ExpUsuariosList')),array('text'=>'Lista','url'=>''));
            
            $em = $this->getDoctrine()->getEntityManager();
            
            if($usuario_obj->getPerfil()->getPerfil()=='Administrador' || $usuario_obj->getPerfil()->getPerfil()=='Abogado Coordinador'){
                $isSearch = false; 
                $searchField = ""; 
                $searchOper = ""; 
                $searchString = ""; 
                $direction = "ASC"; 
                $sort = "u.Proceso"; 
                $rows = "10"; 
                $page = "1";
                return $this->render('ExpidianUsuariosBundle:Usuarios:list_procesos.html.twig', array('breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj, 'is_search'=>$isSearch, 'searchField'=>$searchField, 'searchOper'=>$searchOper, 'searchString'=>$searchString, 'direction'=>$direction, 'sort'=>$sort, 'rows'=>$rows, 'page'=>$page));
            }else{
                return $this->render('ExpidianGlobalBundle::dialog_msj.html.twig', array('msj'=>'Su perfil no posee permisos para efectuar esta acci&oacute;n en el sistema.','class'=>'errorDialogBox', 'breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj));
            }
        }else{
            $estatus = "inicio";
            return $this->render('ExpidianUsuariosBundle:Login:login.html.twig', array('accion'=>'login','estatus'=>$estatus));
        } 
        
    }
    
    public function newAction() 
    {
		$request = $this->getRequest();
        $session = $request->getSession();
                
        $sm = new SessionManager($session);
        $sm->readSession();
        $usuario_obj = $sm->getUsuario();
        
        if($sm->getSession_is_open()){
            
            if($usuario_obj->getPerfil()->getPerfil()=='Administrador' || $usuario_obj->getPerfil()->getPerfil()=='Abogado Coordinador'){
                
                $breadcrumb = array(array('text'=>'Organismos','url'=>$this->generateUrl('ExpOrganismosList')),array('text'=>'Nuevo','url'=>''));
                
                $organismo = new Organismos();
                
                $form = $this->createForm(new OrganismosType(),$organismo);
                
                //Si la petición viene por método post se reciben los datos del formulario se validan los mismos y se crea un nuevo usuario.
                if($request->getMethod()=='POST'){
                    
                    //Con esta sentencia vinculo los valores proporcionados por el formulario a cada uno de los atributos del objeto para que fué configurado. En este caso $usuario
                    $form->bindRequest($request);
                    $em = $this->getDoctrine()->getEntityManager();
                    
                    if($form->isValid()){
                                                
                        $result = $em->getRepository('ExpidianGlobalBundle:Organismos')->GuardarDatosDeOrganismo($organismo, $em);
                        
                        if($result){
                            $msj = 'El Organismo <b>'.$organismo->getNombreOrganismo().'</b>. Para agregar un nuevo organismo haga click <a href='.$this->generateUrl('ExpOrganismosNew').'>aqu&iacute;</a>';
                            $class_style = 'successDialogBox';
                        }else{
                            $msj = 'Ha ocurrido un error en el sistema. Vuelva a intentarlo más tarde. Para agregar un nuevo organismo haga click <a href='.$this->generateUrl('ExpOrganismosNew').'>aqu&iacute;</a>';
                            $class_style = 'errorDialogBox';
                        }
                        
                        return $this->render('ExpidianGlobalBundle::dialog_msj.html.twig', array('msj'=>$msj, 'class'=>$class_style,'breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj));
                        
                    }
                    
                }

                return $this->render('ExpidianGlobalBundle:Organismos:edit_procesos.html.twig', array('form'=>$form->createView(), 'breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj, 'opc'=>'Nuevo'));
                
            }else{
                
                return $this->render('ExpidianGlobalBundle::dialog_msj.html.twig', array('msj'=>'Su perfil no posee permisos para efectuar esta acci&oacute;n en el sistema.','class'=>'errorDialogBox', 'breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj));
                
            }
            
        }else{
            return $this->render('ExpidianUsuariosBundle:Login:login.html.twig', array('accion'=>'login','estatus'=>''));
        } 
    
    
    }
            

    public function editAction($id_proceso) 
    {
    
    }
    
    public function deleteAction($id_proceso) 
    {
        
    }
    
    
    public function ajaxListaUsuariosAction($page)
    {
    
    
    }
        
	
}
