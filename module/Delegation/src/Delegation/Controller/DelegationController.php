<?php

namespace Delegation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Delegation\Model\Delegation;
use Fonction\Controller\IndexController as Fonction;
use Delegation\Form\DelegationForm;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Session\Container;

class DelegationController extends AbstractActionController {

    protected $delegationTable;

     public function indexAction() {

      $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

     
    
        return new ViewModel(array(
            'delegations' => $this->getDelegationTable()->getListeDelegation(),'user' => $user
        ));
    }
    
    
    
     public function listdelegationswsAction() {

         $id = (int) $this->params('id');
        if ($id) {
            
            echo $this->getDelegationTable()->getListeListsDelegationByIdGouvernorat($id);
            exit;
        }else{
           
            exit;
        }
     
      
    }
    
    public function addAction() {
        
         $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $form = new DelegationForm();
        
        $gouvernorat=$this->getDelegationTable()->getListeListsGouvernorat();
        
        
        $listG=array();
        foreach ($gouvernorat as $gouv){
          $listG[$gouv['id']]=$gouv['nom']." / ".$gouv['nomArabe'];
        }
        $form->get('idGouvernorat')->setValueOptions($listG);
        
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $delegation = new Delegation();
            $form->setInputFilter($delegation->getInputFilter());
            if (!$request->getPost()->id) {
                $request->getPost()->id = 0;
            }

            $form->setData($request->getPost());


            if ($form->isValid()) {

                $delegation->exchangeArray($form->getData());

                $this->getDelegationTable()->saveDelegation($delegation);


                // Redirect to list of delegations
                return $this->redirect()->toRoute('delegation');
            } else {


                print_r($form->getMessages());
            }
        } 

        return array('form' => $form,'user' => $user);
    }

    public function editAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('delegation', array('action' => 'add'));
        }
        $delegation = $this->getDelegationTable()->getDelegation($id);

        $form = new DelegationForm();
           $gouvernorat=$this->getDelegationTable()->getListeListsGouvernorat();
        
        
        $listG=array();
        foreach ($gouvernorat as $gouv){
          $listG[$gouv['id']]=$gouv['nom']." / ".$gouv['nomArabe'];
        }
        $form->get('idGouvernorat')->setValueOptions($listG);
        $form->bind($delegation);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getDelegationTable()->saveDelegation($delegation);

                // Redirect to list of delegations
                return $this->redirect()->toRoute('delegation');
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
            return $this->redirect()->toRoute('delegation');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int) $request->getPost()->get('id');
                $this->getDelegationTable()->deleteDelegation($id);
            }

            // Redirect to list of delegations
            return $this->redirect()->toRoute('delegation');
        }

        return array(
            'id' => $id,
            'delegation' => $this->getDelegationTable()->getDelegation($id)
        );
    }

    public function getDelegationTable() {
        if (!$this->delegationTable) {
            $sm = $this->getServiceLocator();
            $this->delegationTable = $sm->get('Delegation\Model\DelegationTable');
           
        }
        return $this->delegationTable;
    }
    


    

}
