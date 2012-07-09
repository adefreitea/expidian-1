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
                $sort = "u.idUsuario"; 
                $rows = "10"; 
                $page = "1";
                return $this->render('ExpidianUsuariosBundle:Usuarios:index.html.twig', array('breadcrumb'=>$breadcrumb,'usuario'=>$usuario_obj, 'is_search'=>$isSearch, 'searchField'=>$searchField, 'searchOper'=>$searchOper, 'searchString'=>$searchString, 'direction'=>$direction, 'sort'=>$sort, 'rows'=>$rows, 'page'=>$page));
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
