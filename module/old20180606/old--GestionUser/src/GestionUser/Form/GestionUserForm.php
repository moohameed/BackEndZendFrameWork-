<?php
namespace GestionUser\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class GestionUserForm extends Form
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
                'type'  => 'hidden',
            ),
        ));
         
        $this->add(array(
            'name' => 'nomUser',
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
            'name' => 'prenomUser',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Prénom',
                 'required' => 'required',
                'class'=>'form-control',
                'id'=>'form-field-1-1',
            ),
            'options' => array(
                'label' => 'Prénom',
                
            ),
        ));
        
             $this->add(array(
            'name' => 'mailUser',
            'attributes' => array(
                'type'  => 'email',
                 'placeholder' => 'mail@email.com',
                 'pattern'=>".{7,100}",
                 'required' => 'required',
                 'class'=>'form-control',
                'id'=>'form-field-1-1'
            ),
            'options' => array(
                'label' => 'E-mail',
               
            ),
              ));
             
              $this->add(array(
            'name' => 'mailUser1',
            'attributes' => array(
                'type'  => 'email',
                 'placeholder' => 'mail@email.com',
                 'pattern'=>".{7,100}",
                 'required' => 'required',
                 'class'=>'form-control',
                'id'=>'form-field-1-1'
            ),
            'options' => array(
                'label' => 'Saisir e-mail à nouveau ',
               
            ),
              ));
             
             $this->add(array(
            'name' => 'adresseUser',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'rue/ville/pays',
               
                'class'=>'form-control',
                'id'=>'form-field-1-1',
            ),
            'options' => array(
                'label' => 'Adresse',
                
            ),
        ));
            $this->add(array( 
            'name' => 'dateNaisUser', 
            'type' => 'date', 
            'attributes' => array(  
                'class'=>'form-control',
            ), 
            'options' => array( 
                'label' => 'Date de naissance', 
            ), 
        )); 
            $this->add(array(
            'name' => 'lieuNaisUser',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Lieu de naissance',
                'class'=>'form-control',
            ),
            'options' => array(
                'label' => 'Lieu De Naissance',
                
            ),
        ));  
            
             $this->add(array(
            'name' => 'telUser',
            'attributes' => array(
                'type'  => 'number',
                'class'=>'form-control',
                'placeholder' => '(+216)00 000 000',
                'pattern'=>".{8,16}",
            ),
            'options' => array(
                'label' => 'Téléphone',
                
            ),
        ));
             $this->add(array( 
            'name' => 'image', 
            'type' => 'File', 
            'attributes' => array(  
            ), 
            'options' => array( 
                'label' => 'Photo de profile', 
            ), 
        )); 
             
             $this->add(array(
            'name' => 'login',
            'attributes' => array(
                'type'  => 'text',
                 'required' => 'required',
                'placeholder' => 'Login',
                'class'=>'form-control',
            ),
            'options' => array(
                'label' => 'Login',
                
            ),
        )); 
             
             $tab=array('1'=>'Admin','2'=>'Chef de projet','3'=>'Coordinateur','4'=>'Superviseur');
             
             $this->add(array( 
            'name' => 'isAdmin', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'required' => 'required', 
                'class'=>'form-control',
            ), 
            'options' => array( 
                'label' => ('Type utilisateur'), 
                'value_options' => $tab,
            ), 
        )); 
             
              $tab=array('1'=>'Actif','2'=>'Inactif');
             
             $this->add(array( 
            'name' => 'etat', 
            'type' => 'Zend\Form\Element\Select', 
            'attributes' => array( 
                'required' => 'required', 
                'class'=>'form-control',
            ), 
            'options' => array( 
                'label' => ('Etat'), 
                'value_options' => $tab,
            ), 
        )); 
             
          /*   $tabType = array();
        $this->add(array(
            'name' => 'gouvernorat',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => ('Type List'),
                'value_options' => $tabType,
            ),
        ));
             
           */       
               
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

