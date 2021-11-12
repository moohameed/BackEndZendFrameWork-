<?php

namespace Lists\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class ListsCherForm extends Form {

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
        
        
         $tabDelegation = array();
        $this->add(array(
            'name' => 'list_idDelegation',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => ('Delegation'),
                'value_options' => $tabDelegation,
            ),
        ));
        
        
        $this->add(array(
            'name' => 'list_nom',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Nom',
            ),
        ));
        $this->add(array(
            'name' => 'list_num',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Num',
            ),
        ));
        $this->add(array(
            'name' => 'list_tete',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Tete list',
            ),
        ));
        $this->add(array(
            'name' => 'list_image',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'Image List',
            ),
        ));
        $this->add(array(
            'name' => 'list_logo',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'Logo List',
            ),
        ));
        $this->add(array(
            'name' => 'list_imageGroup',
            'attributes' => array(
                'type' => 'file',
            ),
            'options' => array(
                'label' => 'Image Group',
            ),
        ));
        $tabType = array('1' => 'حزب', '2' => 'الائتلاف', '3' => 'مستقل');
        $this->add(array(
            'name' => 'list_type',
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
            'name' => 'list_dateValide',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'dateValide',
            ),
        ));
        $this->add(array(
            'name' => 'list_userValide',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'userValide',
            ),
        ));
        $tabPublier = array('0' => 'Non publier', '1' => 'Publier');
        $this->add(array(
            'name' => 'list_publie',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => ('Publier'),
                'value_options' => $tabPublier,
            ),
        ));
        $this->add(array(
            'name' => 'list_datePublie',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'datePublie',
            ),
        ));
        $this->add(array(
            'name' => 'list_userPublie',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'userPublie',
            ),
        ));
        $this->add(array(
            'name' => 'list_deate_creation',
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
