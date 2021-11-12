<?php

namespace Delegation\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class DelegationForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('delegation');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'nom',
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nom',
                
            ),
        ));
        $this->add(array(
            'name' => 'nomArabe',
            'attributes' => array(
                'type' => 'text',
                 'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'nomArabe',
            ),
        ));
        
         $this->add(array(
            'name' => 'nbrChaise',
            'attributes' => array(
                'type' => 'number',
                 'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Nombre chaise',
            ),
        ));
        
        
        
        
        $this->add(array(
            'name' => 'deate_creation',
            'attributes' => array(
                'type' => 'hidden',
                 'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'deate_creation',
            ),
        ));
        
        
         $tabType = array();
        $this->add(array(
            'name' => 'idGouvernorat',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => ('Type List'),
                'value_options' => $tabType,
            ),
        ));



        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'class' => 'pull-right btn btn-small btn-primary',
            ),
        ));
    }

}
