<?php
namespace Application\Form;

use Zend\Form\Form;

class PwdnewForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

       
		
        $this->add(array(
            'name' => 'mailUser',
            'attributes' => array(
                'type'  => 'email','style'=>"width:94%;height: 27px;",
               
                   'placeholder'=>_('E-mail'),
            ),
            'options' => array(
                'label' => '',
            ),
        ));
		
       

		$this->add(array( 
            'name' => 'csrf', 
            'type' => 'Zend\Form\Element\Csrf', 
             'options' => array(
             'csrf_options' => array(
                     'timeout' => 18000
             )
     )
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