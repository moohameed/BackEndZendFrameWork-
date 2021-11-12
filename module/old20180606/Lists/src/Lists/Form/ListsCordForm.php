<?php

namespace Lists\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ListsCordForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('lists');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        
        $this->add(array(
            'name' => 'list_id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        
        $tabValide = array('0' => 'Non valider', '1' => 'Valider');
        $this->add(array(
            'name' => 'list_valide',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => ('Valider'),
                'value_options' => $tabValide,
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
