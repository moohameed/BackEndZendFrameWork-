<?php
namespace Application\Form;

use Zend\Form\Form;

class RegistrationwsForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'usr_login',
            'attributes' => array(
                'type'  => 'text','style'=>"width:94%;height: 27px;",
                'autocomplete'=>"off",
                   'placeholder'=>('Numéro de compte'),
            ),
            'options' => array(
                'label' => '',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'password','style'=>"width:94%;height: 27px;",
                'autocomplete'=>"off",
                   'placeholder'=>('Mot de passe'),
            ),
            'options' => array(
                'label' => '',
            ),
        ));
		
       
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        )); 
    }
}