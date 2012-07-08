<?php

namespace Expidian\ProcesosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('ExpidianProcesosBundle:Default:index.html.twig', array('name' => $name));
    }
}
