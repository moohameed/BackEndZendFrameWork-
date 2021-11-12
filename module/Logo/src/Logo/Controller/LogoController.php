<?php

namespace Logo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Logo\Model\Logo;
use Fonction\Controller\IndexController as Fonction;
use Logo\Form\LogoForm;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Session\Container;
use Zend\Validator\File\Size;

class LogoController extends AbstractActionController {

    protected $logoTable;

    public function indexAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }



        return new ViewModel(array(
            'logos' => $this->getLogoTable()->fetchAll(), 'user' => $user
        ));
    }

    public function addAction() {
        $form = new LogoForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $logo = new Logo();
            $form->setInputFilter($logo->getInputFilter());
            if (!$request->getPost()->id) {
                $request->getPost()->id = 0;
            }

          
            $File = $this->params()->fromFiles('url');
           
            $form->setData($request->getPost());


            if ($form->isValid()) {

                $size = new Size(array('min' => 2));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $files = $adapter->getFileInfo();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }

                    $form->setMessages(array('url' => $error));
                } 
                else {
                   // $adapter->setDestination(dirname(__DIR__) . '/../../../../public/assets/logo');

                    $originalFileName = pathinfo($adapter->getFileName($fileInfo['name'], true));

                    $newFileName = date("YmdHis").'.' . $originalFileName['extension'];
                    
                    $filepath=dirname(__DIR__) . '/../../../../public/assets/logo/';

                    $adapter->addFilter('Rename', array('target' => $filepath . $newFileName, 'overwrite' => true));
                    
                    if ($adapter->receive($file)) {

                        $logo->exchangeArray($form->getData());
                        $logo->deate_creation=date("Y-m-d H:i:s"); 
                        $logo->url=$newFileName;
                        $this->getLogoTable()->saveLogo($logo);
                    }
                }


              

                // Redirect to list of logos
                return $this->redirect()->toRoute('logo');
            } else {


                print_r($form->getMessages());
            }
        }

        return array('form' => $form);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('logo', array('action' => 'add'));
        }
        $logo = $this->getLogoTable()->getLogo($id);

        $form = new LogoForm();
        $form->bind($logo);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            echo '---><pre>';
            print_r($request->getPost());
            
            if ($form->isValid()) {
                  echo '---><pre>';
               print_r($logo->deate_creation); 
                $size = new Size(array('min' => 2));
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $files = $adapter->getFileInfo();
                $adapter->setValidators(array($size), $File['name']);
                if (!$adapter->isValid()) {
                    $dataError = $adapter->getMessages();
                    $error = array();
                    foreach ($dataError as $key => $row) {
                        $error[] = $row;
                    }

                    $form->setMessages(array('url' => $error));
                } 
                else {
                   // $adapter->setDestination(dirname(__DIR__) . '/../../../../public/assets/logo');

                    $originalFileName = pathinfo($adapter->getFileName($fileInfo['name'], true));

                    $newFileName = date("YmdHis").'.' . $originalFileName['extension'];
                    
                    $filepath=dirname(__DIR__) . '/../../../../public/assets/logo/';

                    $adapter->addFilter('Rename', array('target' => $filepath . $newFileName, 'overwrite' => true));
                    
                    if ($adapter->receive($file)) {

                       
                      
                        $logo->url=$newFileName;
                        
                    }
                   
                }
              
               echo '---><pre>';
               print_r($logo->deate_creation); 
                
              exit;  
 $this->getLogoTable()->saveLogo($logo);
                // Redirect to list of logos
                return $this->redirect()->toRoute('logo');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('logo');
        }
        
        

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            
           
            
            
            if ($del == 'Confirmer') {
                $id = (int) $request->getPost()->get('id');
                
               
                $this->getLogoTable()->deleteLogo($id);
            }

            // Redirect to list of logos
            return $this->redirect()->toRoute('logo');
        }

        return array(
            'id' => $id,
            'logo' => $this->getLogoTable()->getLogo($id)
        );
    }

    public function getLogoTable() {
        if (!$this->logoTable) {
            $sm = $this->getServiceLocator();
            $this->logoTable = $sm->get('Logo\Model\LogoTable');
        }
        return $this->logoTable;
    }

}
