<?php

namespace GestionGouvernorat\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class GestionGouvernorat implements InputFilterAwareInterface {

    public $id;
    public $nom;
    public $code;
    public $date_creation;
    public $carte;
    public $nomArabe;
     protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data) {

        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nom = (isset($data['nom'])) ? $data['nom'] : null;
        $this->code = (isset($data['code'])) ? $data['code'] : null;
        $this->date_creation = (isset($data['date_creation'])) ? $data['date_creation'] : null;
        $this->carte = (isset($data['carte'])) ? $data['carte'] : null;
        $this->nomArabe = (isset($data['nomArabe'])) ? $data['nomArabe'] : null;
      
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();


            $inputFilter->add($factory->createInput(array(
                        'name' => 'id',
                        'required' => true,
                        'filters' => array(),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'nom',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'code',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
           
            $inputFilter->add($factory->createInput(array(
                        'name' => 'carte',
                        'required' => FALSE,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min' => 1,
                                    'max' => 100,
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'date_creation',
                        'required' => FALSE,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'Between',
                                'options' => array(
                                ),
                            ),
                        ),
            )));
            $inputFilter->add($factory->createInput(array(
            'name' => 'nomArabe',
            'required' => true,
            'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
            ),
            'validators' => array(
            array(
            'name' => 'StringLength',
            'options' => array(
            'encoding' => 'UTF-8',
            'min' => 1,
            'max' => 100,
            ),
            ),
            ),
            )));

           



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
