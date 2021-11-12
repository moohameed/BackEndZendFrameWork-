<?php

namespace Lists\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Lists implements InputFilterAwareInterface {

    public $list_id;
    public $list_nom;
    public $list_num;
    public $list_tete;
    public $list_image;
    public $list_imageGroup;
    public $list_type;
    public $list_valide;
    public $list_dateValide;
    public $list_userValide;
    public $list_publie;
    public $list_datePublie;
    public $list_userPublie;
    public $list_deate_creation;
    public $list_userCreate;
    public $list_idDelegation;
    public $list_logo;
    public $list_chaise;
    public $list_vote;
    public $list_taux;
    public $list_users;
    public $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data) {

        $this->list_id = (isset($data['list_id'])) ? $data['list_id'] : null;
        $this->list_nom = (isset($data['list_nom'])) ? $data['list_nom'] : null;
        $this->list_num = (isset($data['list_num'])) ? $data['list_num'] : null;
        $this->list_tete = (isset($data['list_tete'])) ? $data['list_tete'] : null;
        $this->list_image = (isset($data['list_image'])) ? $data['list_image'] : null;
        $this->list_imageGroup = (isset($data['list_imageGroup'])) ? $data['list_imageGroup'] : null;
        $this->list_type = (isset($data['list_type'])) ? $data['list_type'] : null;
        $this->list_valide = (isset($data['list_valide'])) ? $data['list_valide'] : null;
        $this->list_dateValide = (isset($data['list_dateValide'])) ? $data['list_dateValide'] : null;
        $this->list_userValide = (isset($data['list_userValide'])) ? $data['list_userValide'] : null;
        $this->list_publie = (isset($data['list_publie'])) ? $data['list_publie'] : null;
        $this->list_datePublie = (isset($data['list_datePublie'])) ? $data['list_datePublie'] : null;
        $this->list_userPublie = (isset($data['list_userPublie'])) ? $data['list_userPublie'] : null;
        $this->list_deate_creation = (isset($data['list_deate_creation'])) ? $data['list_deate_creation'] : null;
        $this->list_userCreate = (isset($data['list_userCreate'])) ? $data['list_userCreate'] : null;
        $this->list_logo = (isset($data['list_logo'])) ? $data['list_logo'] : null;
        $this->list_idDelegation = (isset($data['list_idDelegation'])) ? $data['list_idDelegation'] : null;
      
                 $this->list_chaise = (isset($data['list_chaise'])) ? $data['list_chaise'] : null;
         $this->list_vote = (isset($data['list_vote'])) ? $data['list_vote'] : null;
          $this->list_taux = (isset($data['list_taux'])) ? $data['list_taux'] : null;
           $this->list_users = (isset($data['list_users'])) ? $data['list_users'] : null;
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
                        'name' => 'list_id',
                        'required' => true,
                        'filters' => array(),
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'list_nom',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_num',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_tete',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_image',
                        'required' => false,
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'list_imageGroup',
                        'required' => false,
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'list_logo',
                        'required' => false,
            )));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'list_type',
                        'required' => true,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_valide',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_dateValide',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_userValide',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_publie',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_datePublie',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_userPublie',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
                        'name' => 'list_deate_creation',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ), 'validators' => array(
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
