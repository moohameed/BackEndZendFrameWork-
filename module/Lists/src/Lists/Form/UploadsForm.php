<?php

namespace Lists\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UploadsForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('lists');

        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype', 'multipart/form-data');
        
        $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'Image List',
            ),
        ));
       
    }

}
