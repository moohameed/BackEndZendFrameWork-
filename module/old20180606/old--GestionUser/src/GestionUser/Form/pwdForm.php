<?php
namespace GestionUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class pwdForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        
     $this->setAttribute('method', 'post');
    
    $this->add(array(
            'name' => 'idUser',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
     
    $this->add(array(
            'name' => 'pwd',
            'attributes' => array(
                'type'  => 'password',
                 'required' => 'required',
                'class'=>'form-control',
              
            ),
            'options' => array(
                'label' => 'Mot de passe Actuel' ,
            ),
        ));
    $this->add(array(
            'name' => 'pwd1',
            'attributes' => array(
                'type'  => 'password',
                 'required' => 'required',
                'class'=>'form-control',
              
            ),
            'options' => array(
                'label' => 'Nouveau Mot de passe' ,
            ),
        ));
    $this->add(array(
            'name' => 'pwd2',
            'attributes' => array(
                'type'  => 'password',
                 'required' => 'required',
                'class'=>'form-control',
              
            ),
            'options' => array(
                'label' => 'Saisir à nouveau' ,
            ),
        ));
    
    $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
               
                 'class' => 'pull-right btn btn-small btn-primary',
            ),
        ));
}
}




