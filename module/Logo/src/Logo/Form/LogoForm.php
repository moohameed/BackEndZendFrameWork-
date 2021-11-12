<?php

namespace Logo\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class LogoForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('logo');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');
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
            'name' => 'url',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'File Upload',
            ),
        ));
        $this->add(array(
            'name' => 'deate_creation',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'deate_creation',
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
