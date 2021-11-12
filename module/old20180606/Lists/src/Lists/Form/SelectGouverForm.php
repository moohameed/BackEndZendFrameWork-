<?php

namespace Lists\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class SelectGouverForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('lists');

        $this->setAttribute('method', 'post');
        
        
        $tabType = array();
        $this->add(array(
            'name' => 'gouvernorat',
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
