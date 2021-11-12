<?php

namespace GestionUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SelectTypeForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('user');

        $this->setAttribute('method', 'post');
        
        
        $tabType = array(1=>'Admin',2=>'Chef du projet',3=>"Coordinateur",4=>"Superviseur");
        $this->add(array(
            'name' => 'isAdmin',
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
