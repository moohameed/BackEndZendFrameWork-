<?php

namespace GestionUser\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class GestionUser implements InputFilterAwareInterface {

    public $idUser;
    public $nomUser;
    public $prenomUser;
    public $mailUser;
    public $adresseUser;
    public $dateNaisUser;
    public $lieuNaisUser;
    public $telUser;
    public $image;
    public $login;
    public $pwd;
    public $isAdmin;
    public $etat;
    public $pwdc;
    public $gouvernorat;
    public $delegations;
    public $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data) {

        $this->idUser = (isset($data['idUser'])) ? $data['idUser'] : null;
        $this->nomUser = (isset($data['nomUser'])) ? $data['nomUser'] : null;
        $this->prenomUser = (isset($data['prenomUser'])) ? $data['prenomUser'] : null;
        $this->mailUser = (isset($data['mailUser'])) ? $data['mailUser'] : null;
        $this->adresseUser = (isset($data['adresseUser'])) ? $data['adresseUser'] : null;
        $this->dateNaisUser = (isset($data['dateNaisUser'])) ? $data['dateNaisUser'] : null;
        $this->lieuNaisUser = (isset($data['lieuNaisUser'])) ? $data['lieuNaisUser'] : null;
        $this->telUser = (isset($data['telUser'])) ? $data['telUser'] : null;
        $this->image = (isset($data['image'])) ? $data['image'] : null;
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->pwd = (isset($data['pwd'])) ? $data['pwd'] : null;
        $this->pwdc = (isset($data['pwdc'])) ? $data['pwdc'] : null;
         $this->gouvernorat = (isset($data['gouvernorat'])) ? $data['gouvernorat'] : null;
         $this->delegations = (isset($data['delegations'])) ? $data['delegations'] : null;

        $this->isAdmin = (isset($data['isAdmin'])) ? $data['isAdmin'] : null;
        $this->etat = (isset($data['etat'])) ? $data['etat'] : null;
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
                        'name' => 'idUser',
                        'required' => true,
                        'filters' => array(),
            )));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'nomUser',
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
                        'name' => 'prenomUser',
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
                        'name' => 'mailUser',
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
                        'name' => 'mailUser1',
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
                        'name' => 'adresseUser',
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
                        'name' => 'dateNaisUser',
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
            'name' => 'lieuNaisUser',
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

            /*
              $inputFilter->add($factory->createInput(array(
              'name' => 'image',
              'required' => FALSE,

              'filters' => array(
              array('name' => 'File'),
              'target' => '/img/',
              'randomize' => true,

              ),
              'validators' => array(
              array(
              'name' => 'Between',
              'options' => array(
              'extension' =>array('gif', 'jpg'),
              ),
              ),
              )

             

            ) ));*/

            $inputFilter->add($factory->createInput(array(
                        'name' => 'login',
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
                        'name' => 'isAdmin',
                        'required' => false,
                        'filters' => array(),
            )));



            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}
