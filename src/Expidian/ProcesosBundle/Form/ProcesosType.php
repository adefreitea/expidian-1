<?php

namespace Expidian\GlobalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PersonasType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('idProceso','hidden')
            ->add('proceso')
            ->add('procesoAbrev')
            ->add('nroConsecutivoProceso','number')        
        ;
    }
           
    public function getName()
    {
        return 'procesotype';
    }
}
