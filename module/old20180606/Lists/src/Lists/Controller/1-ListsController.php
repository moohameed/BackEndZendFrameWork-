<?php

namespace Lists\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Lists\Model\Lists;
use Fonction\Controller\IndexController as Fonction;
use Lists\Form\UploadsForm;
use Lists\Form\ListsForm;
use Lists\Form\ListsSuperForm;
use Lists\Form\ListsCordForm;
use Lists\Form\ListsCherForm;
use Lists\Form\SelectGouverForm;
use Zend\Mail\Message;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Zend\Session\Container;
use Zend\Validator\File\Size;

class ListsController extends AbstractActionController {

    protected $listsTable;

    public function indexAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

//$this->getListsTable()->getListeLists();

        return new ViewModel(array(
            'lists' => $this->getListsTable()->getListeLists(), 'lists2' => $this->getListsTable()->fetchAll(), 'user' => $user
        ));
    }

    public function cheflistsAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

//$this->getListsTable()->getListeLists();

        return new ViewModel(array(
            'lists' => $this->getListsTable()->getListeLists(), 'lists2' => $this->getListsTable()->fetchAll(), 'user' => $user
        ));
    }

    public function editchefAction() {

        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('lists', array('action' => 'index'));
        }
        $lists = $this->getListsTable()->getLists($id);
        $ListeEdit = $this->getListsTable()->getLists($id);



        $infoDelegation = $this->getListsTable()->getDelegationById($lists->list_idDelegation);
        $delegations = $this->getListsTable()->getListeListsDelegationByIdGouvernorat($infoDelegation['0']['idGouvernorat']);



        $listD = array();
        foreach ($delegations as $delegation) {

            $ch = $delegation['nom'];
            if ($delegation['nomArabe'])
                $ch = $ch . " / " . $delegation['nomArabe'];
            $listD[$delegation['id']] = $ch;
        }

        $form = new ListsForm();
        $form->get('list_idDelegation')->setValueOptions($listD);
        $form->bind($lists);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($lists->getInputFilter());
            $form->setData($request->getPost());


            if ($form->isValid()) {



                $FileImage = $this->params()->fromFiles('list_image');
                $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                $FileImageLogo = $this->params()->fromFiles('list_logo');
                $newNameImageGroup = $ListeEdit->list_imageGroup;
                $newNameImage = $ListeEdit->list_image;
                $newNameImageLogo = $ListeEdit->list_logo;

                if (!$FileImageLogo['error']) {
                    $FileImageLogo = $this->params()->fromFiles('list_image');
                    $FileImageLogoNewName = 'Logo-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/logo';
                    $ext = pathinfo($FileImageLogo['name'], PATHINFO_EXTENSION);
                    $newNameImageLogo = $FileImageLogoNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageLogo,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_logo']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImage['error']) {
                    $FileImage = $this->params()->fromFiles('list_image');
                    $FileImageNewName = 'List-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageList';
                    $ext = pathinfo($FileImage['name'], PATHINFO_EXTENSION);
                    $newNameImage = $FileImageNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImage,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_image']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImageGroup['error']) {
                    $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                    $FileImageGroupNewName = 'ListGroup-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageListGroup';
                    $ext = pathinfo($FileImageGroup['name'], PATHINFO_EXTENSION);
                    $newNameImageGroup = $FileImageGroupNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageGroup,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_imageGroup']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }



                if ($newNameImage != "")
                    $lists->list_image = $newNameImage;
                if ($newNameImageGroup != "")
                    $lists->list_imageGroup = $newNameImageGroup;
                if ($newNameImageLogo != "")
                    $lists->list_logo = $newNameImageLogo;

                $lists->list_deate_creation = $ListeEdit->list_deate_creation;




                $this->getListsTable()->saveLists($lists);

                // Redirect to list of listss
                return $this->redirect()->toRoute('lists');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function corlistsAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }
        if ($user->isAdmin != 3)
            return $this->redirect()->toUrl('/');


      
        

//$this->getListsTable()->getListeLists();
        $listg = json_decode($user->gouvernorat, 1);
        return new ViewModel(array(
            'lists' => $this->getListsTable()->getListeListscord($listg),
            'user' => $user
        ));
    }

    public function superlistsAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

//$this->getListsTable()->getListeLists();

        return new ViewModel(array(
            'lists' => $this->getListsTable()->getListeLists(), 'lists2' => $this->getListsTable()->fetchAll(), 'user' => $user
        ));
    }

    public function listswsAction() {
        // ini_set('display_errors', '1');
        $id = (int) $this->params('id');

        $type = (int) $this->params('type');
        if ($id) {
            // echo 'id---->'.$id;
            echo $this->getListsTable()->getListeListsws($id, $type);
            /* if($type){
              echo '-----type---->'.$type;
              } */
        }

        exit();
    }

    public function getlistsbyidwsAction() {
        // ini_set('display_errors', '1');
        $id = (int) $this->params('id');

        $type = (int) $this->params('type');
        if ($id) {
            // echo 'id---->'.$id;
            echo $this->getListsTable()->getListeListsByIdws($id);
            /* if($type){
              echo '-----type---->'.$type;
              } */
        }

        exit();
    }

    public function selectgAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }


        $gouvernorat = $this->getListsTable()->getListeListsGouvernorat();


        $listG = array();
        foreach ($gouvernorat as $gouv) {
            $listG[$gouv['id']] = $gouv['nom'] . " / " . $gouv['nomArabe'];
        }


        $form = new SelectGouverForm();
        $form->get('gouvernorat')->setValueOptions($listG);
        $form->get('submit')->setAttribute('value', 'select');
        $request = $this->getRequest();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $post = $request->getPost();
                return $this->redirect()->toUrl('add/' . $post->gouvernorat);
            }
        }
        return array('form' => $form);
    }

    public function addAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('lists', array('action' => 'selectg'));
        }

        $delegations = $this->getListsTable()->getListeListsDelegationByIdGouvernorat($id);



        $listD = array();
        foreach ($delegations as $delegation) {

            $ch = $delegation['nom'];
            if ($delegation['nomArabe'])
                $ch = $ch . " / " . $delegation['nomArabe'];
            $listD[$delegation['id']] = $ch;
        }



        $form = new ListsForm();
        $form->get('list_idDelegation')->setValueOptions($listD);
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $lists = new Lists();
            $form->setInputFilter($lists->getInputFilter());
            if (!$request->getPost()->list_id) {
                $request->getPost()->list_id = 0;
            }

            $form->setData($request->getPost());


            if ($form->isValid()) {

                $FileImage = $this->params()->fromFiles('list_image');
                $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                $FileImageLogo = $this->params()->fromFiles('list_logo');

                $newNameImageGroup = "";
                $newNameImage = "";
                $newNameImageLogo = "";

                if (!$FileImageLogo['error']) {
                    $FileImageLogo = $this->params()->fromFiles('list_image');
                    $FileImageLogoNewName = 'Logo-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/logo';
                    $ext = pathinfo($FileImageLogo['name'], PATHINFO_EXTENSION);
                    $newNameImageLogo = $FileImageLogoNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageLogo,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_logo']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImage['error']) {
                    $FileImage = $this->params()->fromFiles('list_image');
                    $FileImageNewName = 'List-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageList';
                    $ext = pathinfo($FileImage['name'], PATHINFO_EXTENSION);
                    $newNameImage = $FileImageNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImage,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_image']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImageGroup['error']) {
                    $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                    $FileImageGroupNewName = 'ListGroup-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageListGroup';
                    $ext = pathinfo($FileImageGroup['name'], PATHINFO_EXTENSION);
                    $newNameImageGroup = $FileImageGroupNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageGroup,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_imageGroup']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                $lists->exchangeArray($form->getData());

                if ($newNameImage != "")
                    $lists->list_image = $newNameImage;
                if ($newNameImageGroup != "")
                    $lists->list_imageGroup = $newNameImageGroup;
                if ($newNameImageLogo != "")
                    $lists->list_logo = $newNameImageLogo;
                $lists->list_deate_creation = date("Y-m-d H:i:s");


                $lists->list_userCreate = $user->idUser;
                // $lists->list_idDelegation = 1;


                $this->getListsTable()->saveLists($lists);
                /* echo "<pre>";
                  print_r($lists); */





                // Redirect to list of listss
                return $this->redirect()->toRoute('lists');
            }
        }

        return array('form' => $form, 'id' => $id);
    }

    public function uploadeimagelistwsAction() {

        //  $form = new ListsForm();

        $id = (int) $this->params('id');
        if (!$id) {
             echo 'invalide parame';
                exit;
        }
        $lists = $this->getListsTable()->getLists($id);
        $request = $this->getRequest();
        if ($request->isPost()) {

            $FileImage = $this->params()->fromFiles('image');
            if (!$FileImageLogo['error']) {
                $FileImageLogo = $this->params()->fromFiles('image');
                $FileImageLogoNewName = 'List-' . date("YmdHis");
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $destination = dirname(__DIR__) . '/../../../../public/assets/imageList';
                $ext = pathinfo($FileImageLogo['name'], PATHINFO_EXTENSION);
                $newNameImageLogo = $FileImageLogoNewName . '.' . $ext;
                $adapter->addFilter('File\Rename', array(
                    'target' => $destination . '/' . $newNameImageLogo,
                ));
                $info = $adapter->getFileInfo();
                if ($adapter->receive($info['list_logo']['name'])) {
                    $file = $adapter->getFilter('File\Rename')->getFile();
                    $target = $file[0]['target'];
                }

               
                
               $lists->list_image = $newNameImageLogo;
                $this->getListsTable()->saveLists($lists);
                echo 'fin upload-->'.$newNameImageLogo;
                exit;
            }
        } else {
            echo 'post invalide';
            exit;
        }
    }
    
     public function uploadeimagegroupwsAction() {

        //  $form = new ListsForm();

        $id = (int) $this->params('id');
        if (!$id) {
             echo 'invalide parame';
                exit;
        }
        $lists = $this->getListsTable()->getLists($id);
        $request = $this->getRequest();
        if ($request->isPost()) {

            $FileImage = $this->params()->fromFiles('image');
            if (!$FileImageLogo['error']) {
                $FileImageLogo = $this->params()->fromFiles('image');
                $FileImageLogoNewName = 'ListGroup-' . date("YmdHis");
                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $destination = dirname(__DIR__) . '/../../../../public/assets/imageListGroup';
                $ext = pathinfo($FileImageLogo['name'], PATHINFO_EXTENSION);
                $newNameImageLogo = $FileImageLogoNewName . '.' . $ext;
                $adapter->addFilter('File\Rename', array(
                    'target' => $destination . '/' . $newNameImageLogo,
                ));
                $info = $adapter->getFileInfo();
                if ($adapter->receive($info['list_logo']['name'])) {
                    $file = $adapter->getFilter('File\Rename')->getFile();
                    $target = $file[0]['target'];
                }

               
                
               $lists->list_imageGroup = $newNameImageLogo;
                $this->getListsTable()->saveLists($lists);
                echo 'fin upload-->'.$newNameImageLogo;
                exit;
            }
        } else {
            echo 'post invalide';
            exit;
        }
    }

    public function editAction() {

        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('lists', array('action' => 'index'));
        }
        $lists = $this->getListsTable()->getLists($id);
        $ListeEdit = $this->getListsTable()->getLists($id);



        $infoDelegation = $this->getListsTable()->getDelegationById($lists->list_idDelegation);
        $delegations = $this->getListsTable()->getListeListsDelegationByIdGouvernorat($infoDelegation['0']['idGouvernorat']);



        $listD = array();
        foreach ($delegations as $delegation) {

            $ch = $delegation['nom'];
            if ($delegation['nomArabe'])
                $ch = $ch . " / " . $delegation['nomArabe'];
            $listD[$delegation['id']] = $ch;
        }

        $form = new ListsForm();
        $form->get('list_idDelegation')->setValueOptions($listD);
        $form->bind($lists);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($lists->getInputFilter());
            $form->setData($request->getPost());


            if ($form->isValid()) {



                $FileImage = $this->params()->fromFiles('list_image');
                $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                $FileImageLogo = $this->params()->fromFiles('list_logo');
                $newNameImageGroup = $ListeEdit->list_imageGroup;
                $newNameImage = $ListeEdit->list_image;
                $newNameImageLogo = $ListeEdit->list_logo;

                if (!$FileImageLogo['error']) {
                    $FileImageLogo = $this->params()->fromFiles('list_image');
                    $FileImageLogoNewName = 'Logo-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/logo';
                    $ext = pathinfo($FileImageLogo['name'], PATHINFO_EXTENSION);
                    $newNameImageLogo = $FileImageLogoNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageLogo,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_logo']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImage['error']) {
                    $FileImage = $this->params()->fromFiles('list_image');
                    $FileImageNewName = 'List-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageList';
                    $ext = pathinfo($FileImage['name'], PATHINFO_EXTENSION);
                    $newNameImage = $FileImageNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImage,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_image']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }

                if (!$FileImageGroup['error']) {
                    $FileImageGroup = $this->params()->fromFiles('list_imageGroup');
                    $FileImageGroupNewName = 'ListGroup-' . date("YmdHis");
                    $adapter = new \Zend\File\Transfer\Adapter\Http();
                    $destination = dirname(__DIR__) . '/../../../../public/assets/imageListGroup';
                    $ext = pathinfo($FileImageGroup['name'], PATHINFO_EXTENSION);
                    $newNameImageGroup = $FileImageGroupNewName . '.' . $ext;
                    $adapter->addFilter('File\Rename', array(
                        'target' => $destination . '/' . $newNameImageGroup,
                    ));
                    $info = $adapter->getFileInfo();
                    if ($adapter->receive($info['list_imageGroup']['name'])) {
                        $file = $adapter->getFilter('File\Rename')->getFile();
                        $target = $file[0]['target'];
                    }
                }



                if ($newNameImage != "")
                    $lists->list_image = $newNameImage;
                if ($newNameImageGroup != "")
                    $lists->list_imageGroup = $newNameImageGroup;
                if ($newNameImageLogo != "")
                    $lists->list_logo = $newNameImageLogo;

                $lists->list_deate_creation = $ListeEdit->list_deate_creation;




                $this->getListsTable()->saveLists($lists);

                // Redirect to list of listss
                return $this->redirect()->toRoute('lists');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }
    
    
    public function editcordAction() {
        
        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('lists', array('action' => 'editcord'));
        }
        $lists = $this->getListsTable()->getLists($id);
        $ListeEdit = $this->getListsTable()->getLists($id);


        $form = new ListsCordForm();
        
        $form->bind($lists);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$form->setInputFilter($lists->getInputFilter());
            $form->setData($request->getPost());

                
                $posteData=$request->getPost();
                if($posteData->list_valide){
                    $ListeEdit->list_valide=1;
                    $ListeEdit->list_dateValide=date("Y-m-d H:i:s");
                    $ListeEdit->list_userValide=$user->idUser;
                }else{
                    $ListeEdit->list_valide=0; 
                }
                
                $this->getListsTable()->saveLists($ListeEdit);
                return $this->redirect()->toUrl('/lists/corlists');
                
                 

           
        }

        return array(
            'liste'=>$lists,
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $id = (int) $this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('lists');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Confirmer') {
                $id = (int) $request->getPost()->get('id');
                $this->getListsTable()->deleteLists($id);
            }

            // Redirect to list of listss
            return $this->redirect()->toRoute('lists');
        }

        return array(
            'id' => $id,
            'lists' => $this->getListsTable()->getLists($id)
        );
    }

    public function getListsTable() {
        if (!$this->listsTable) {
            $sm = $this->getServiceLocator();
            $this->listsTable = $sm->get('Lists\Model\ListsTable');
        }
        return $this->listsTable;
    }

}
