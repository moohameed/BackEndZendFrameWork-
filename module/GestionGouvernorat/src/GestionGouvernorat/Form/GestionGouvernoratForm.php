<?php
namespace GestionGouvernorat\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class GestionGouvernoratForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('gouvernorat');

        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        
         
        $this->add(array(
            'name' => 'nom',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'nom',
                 'required' => 'required',
                'class'=>'form-control',
                'id'=>'form-field-1-1',
            ),
            'options' => array(
                'label' => 'Nom',
            ),
        ));
        

        $this->add(array(
            'name' => 'code',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Code',
                 'required' => 'required',
                'class'=>'form-control',
                'id'=>'form-field-1-1',
            ),
            'options' => array(
                'label' => 'Code',
                
            ),
        ));
        
           
             
           
             
             $this->add(array(
            'name' => 'carte',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'carte',
               
                'class'=>'form-control',
                'id'=>'form-field-1-1',
            ),
            'options' => array(
                'label' => 'carte',
                
            ),
        ));
            $this->add(array( 
            'name' => 'nomArabe', 
            'type' => 'text', 
            'attributes' => array(  
                'class'=>'form-control',
            ), 
            'options' => array( 
                'label' => 'nom Arabe', 
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

