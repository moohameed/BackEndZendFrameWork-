<?php

namespace GestionUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use GestionUser\Model\GestionUser;
use GestionUser\Form\GestionUserForm;
use GestionUser\Form\SelectTypeForm;
use Lists\Form\SelectGouverForm;
use GestionUser\Form\pwdForm;
use Zend\Mail\Message;
use Zend\InputFilter;
use Zend\Session\Container;
use Zend\Validator\File\Size;

class GestionUserController extends AbstractActionController {

    protected $userTable;

    public function indexAction() {

        $userContainer = new Container('user');
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $user = new GestionUser();
        $user = $userContainer->utilisateur;
        $id = $user->idUser;
        return new ViewModel(array(
            'users' => $this->getGestionUserTable()->fetchAll(),
            'user' => $this->getGestionUserTable()->getGestionUser($id)));
    }

    public function detailAction() {

        $userContainer = new Container('user');
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $user = new GestionUser();
        $user = $userContainer->utilisateur;
        $id = $user->idUser;
        $id = (int) $this->params('idUser');

        if (!$id) {
            return $this->redirect()->toRoute('user', array('action' => 'index'));
        }
        return new ViewModel(array(
            'user' => $this->getGestionUserTable()->getGestionUser($id)));
    }

    public function testAction() {

        $userContainer = new Container('user');
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $user = new GestionUser();
        $user = $userContainer->utilisateur;

        return new ViewModel(array(
            'users' => $this->getGestionUserTable()->fetchAll(),
        ));
    }

    public function listeuserwsAction() {

        echo '{"page":"1","total":1,"records":"13","rows":[{"id":"77896","cell":["163","77896","1427194281M","android.fr","csdc","sdcdsc","25,000","TND","24\/03\/2015","Comp","En attente","163"]},{"id":"77895","cell":["163","77895","1426518512M","android.fr","jerda","saber","20,000","TND","24\/03\/2015","Comp","En attente","163"]},{"id":"77873","cell":["163","77873","150217140502M","android.fr","Boudali","Nadia","2,000","TND","16\/03\/2015","Comp","En attente","163"]},{"id":"77870","cell":["163","77870","1426255974M","android.fr","jerda","saber","20,000","TND","13\/03\/2015","Comp","En attente","163"]},{"id":"77868","cell":["163","77868","1426258378M","android.fr","nom client","prenom client","15,000","TND","13\/03\/2015","Comp","En attente","163"]},{"id":"77867","cell":["163","77867","1425720101M","android.fr","jerda","saber","20,000","TND","13\/03\/2015","Comp","En attente","163"]},{"id":"68642","cell":["163","68642","1420628954M","android.fr","jerda","saber","19,200","TND","07\/01\/2015","Comp","En attente","163"]},{"id":"68639","cell":["165","68639","0000164794M","bigdeal.tn"," Jerda","saber","15,000","TND","07\/01\/2015","Comp","En attente","165"]},{"id":"68636","cell":["165","68636","0000164776M","bigdeal.tn"," feki","faiza","19,000","TND","07\/01\/2015","Comp","En attente","165"]},{"id":"50125","cell":["257","50125","1410522237M","shop1.tn","rania","ammous","100,000","TND","12\/09\/2014","Comp","En attente","257"]},{"id":"50123","cell":["257","50123","140818132631M","shop1.tn","prenom","sabera","300,000","TND","12\/09\/2014","Comp","En attente","257"]},{"id":"42854","cell":["163","42854","88","android.fr","rania","rania","1,000","TND","22\/07\/2014","Comp","En attente","163"]},{"id":"42097","cell":["257","42097","140715122136","shop1.tn","Rania","Ammous","50,000","TND","15\/07\/2014","Comp","En attente","257"]}]}';
        exit;
    }

    public function profilAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $user = new GestionUser();
        $user = $userContainer->utilisateur;

        $view = new ViewModel(array('user' => $user));

        return $view;
    }

    public function selectgAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }


        $gouvernorat = $this->getGestionUserTable()->getListeListsGouvernorat();


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

    public function selecttypeAction() {

        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }

        $form = new SelectTypeForm();

        $form->get('submit')->setAttribute('value', 'select');
        $request = $this->getRequest();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $post = $request->getPost();
                //  if($post->isAdmin==4){
                return $this->redirect()->toUrl('add/' . $post->isAdmin);
                //  }else{
                //  return $this->redirect()->toUrl('add/' . $post->isAdmin);
                // }
            }
        }
        return array('form' => $form);
    }

    public function addAction() {
        $form = new GestionUserForm();
        $form->get('submit')->setAttribute('value', 'Ajouter');
        $request = $this->getRequest();

        $id = (int) $this->params('idUser');

        if (!$id) {
            return $this->redirect()->toRoute('user', array('action' => 'selecttype'));
        }




        if ($request->isPost()) {

            if (!$request->getPost()->idUser) {
                $request->getPost()->idUser = 0;
            }

           /* if (!$request->getPost()->gouvernorat) {
                $request->getPost()->gouvernorat = 1;
            }*/

            $postarray = $request->getPost()->toArray();

            $listeSelectDelegation = array();
            if ($id == 4) {
                foreach ($postarray as $key => $value) {
                    if (is_int($key)) {
                        $listeSelectDelegation[] = $value;
                    }
                }
            }
            
             $listeSelectGovernora = array();
            if ($id == 3) {
                foreach ($postarray as $key => $value) {
                    if (is_int($key)) {
                        $listeSelectGovernora[] = $value;
                    }
                }
            }


            $user = new GestionUser();
            $form->setInputFilter($user->getInputFilter());
            //$postdata = $request->getPost();
            $postdata = array_merge_recursive(
                    $request->getPost()->toArray(), $request->getFiles()->toArray());
            $form->setData($postdata); // $postdata au lieu de $request->getPost()
            $image = $postdata['image'];
            /* echo $user->image;
              exit(); */
            $mailUser = $postdata['mailUser'];
            $mailUser1 = $postdata['mailUser1'];
            $validermail = strcmp($mailUser, $mailUser1);

            if ($validermail == 0) {
                if ($form->isValid()) {
                    $user->exchangeArray($request->getPost());
                    $user->image = $image['tmp_name'];
                    $user->mailUser = $mailUser1;
                    $pwd = $this->generatePWD();
                    $user->pwd = $pwd;
                    $user->pwdc = $pwd;
                    $user->isAdmin = $id;
                    if ($id == 4) {
                        $user->delegations = json_encode($listeSelectDelegation);
                    }
                    
                    if ($id == 3) {
                        $user->gouvernorat = json_encode($listeSelectGovernora);
                    }
                    $this->getGestionUserTable()->saveGestionUser($user);
                    //  $this->envoieMail($user->nomUser, $user->prenomUser, $user->login, $user->mailUser, $pwd);
                    $view = new ViewModel(array('form' => $form,
                        'success' => "true", 'messageSuccess' => "Compte ajout?? avec succ??s"));
                    return $view;
                } else {
                    echo 'form invalide<pre>';
                    print_r($form->getMessages());
                    exit;
                }
            } else {
                $view = new ViewModel(array('form' => $form,
                    'messageErreur' => "true", 'message' => "Veuillez v??rifier votre adresse mail"));
                return $view;
            }
        }
        
        
        
        
 $listG = array();
        if ($id == 3) {
            $gouvernorat = $this->getGestionUserTable()->getListeListsGouvernorat();
            $listG = array();
            foreach ($gouvernorat as $gouv) {
                $listG[] = array('id'=>$gouv['id'],'nam'=>$gouv['nom'] . " / " . $gouv['nomArabe']);
            }
            //$form->get('gouvernorat')->setValueOptions($listG);
        }
        
       

        $listedelegation = array();
        if ($id == 4) {
            $listedelegation = $this->getGestionUserTable()->getListeDelegation();
            $listefinalDelegation = array();
            foreach ($listedelegation as $deleg) {
                $listefinalDelegation[$deleg['idGouvernorat']][] = $deleg;
            }
        }

        return array('form' => $form, 'id' => $id,
            'listedelegation' => $listefinalDelegation,'listG'=>$listG);
    }

    public function editAction() {
        $id = (int) $this->params('idUser');

        if (!$id) {
            return $this->redirect()->toRoute('user', array('action' => 'add'));
        }
        $user = $this->getGestionUserTable()->getGestionUser($id);

        //$user->mailUser1 = $user->mailUser;
        $form = new GestionUserForm();
        $form->bind($user);

        $form->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            $postdata = $request->getPost();
            $mailUser = $postdata['mailUser'];
            $mailUser1 = $postdata['mailUser1'];
            $validermail = strcmp($mailUser, $mailUser1);
            if ($validermail != 0) {
                $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                    'messageErreur' => "true", 'message' => "Veuillez v??rifier votre adresse mail"));
                return $view;
            } else {
                if (1) {
                    $usermodif = new GestionUser();
                    $usermodif->exchangeArray($request->getPost());
                    $usermodif->idUser = $user->idUser;
                    $usermodif->mailUser = $mailUser1;
                    $usermodif->pwd = $user->pwd;
                    $usermodif->pwdc = $user->pwd;

                    $this->getGestionUserTable()->saveGestionUser($usermodif);
                    $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                        'success' => "true", 'messageSuccess' => "modification avec succ??s"));
                    return $view;
                }
            }
        }
        $view = new ViewModel(array('idUser' => $id, 'form' => $form));
        return $view;
    }

    public function modifierAction() {
        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }
        $user = new GestionUser();
        $user = $userContainer->utilisateur;
        $id = $user->idUser;
        $user = $this->getGestionUserTable()->getGestionUser($id);
        $form = new GestionUserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setData($request->getPost());

            if (1) {

                $usermodif = new GestionUser();

                $usermodif->exchangeArray($request->getPost());
                $usermodif->idUser = $user->idUser;
                $this->getGestionUserTable()->saveGestionUser($usermodif);
                $user = $this->getGestionUserTable()->getGestionUser($id);
                $userContainer->utilisateur = $user;
                $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                    'success' => "true", 'messageSuccess' => "Votre profil a ??t?? modifi??."));
                return $view;
            } else {
                $view = new ViewModel(array('form' => $form,
                    'messageErreur' => "true", 'message' => "Veuillez v??rifier les informations saisies"));
                return $view;
            }
            return array(
                'idUser' => $id,
                'form' => $form,
            );
        }
        return array('form' => $form);
    }

    public function deleteAction() {
        $id = (int) $this->params('idUser');
        if (!$id) {
            return $this->redirect()->toRoute('user');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'Annuler');
            if ($del == 'Confirmer') {
                $id = (int) $request->getPost()->get('idUser');
                $this->getGestionUserTable()->deleteGestionUser($id);
            }
            // Redirect to list of user
            return $this->redirect()->toRoute('user');
        }

        return array(
            'idUser' => $id,
            'user' => $this->getGestionUserTable()->getGestionUser($id)
        );
    }

    public function getGestionUserTable() {
        if (!$this->userTable) {
            $sm = $this->getServiceLocator();
            $this->userTable = $sm->get('GestionUser\Model\GestionUserTable');
        }
        return $this->userTable;
    }

    public function envoieMail($nom, $prenom, $login, $mail, $pwd) {

        $transport = $this->getServiceLocator()->get('mail.transport');
        $message = new Message();

        $this->getRequest()->getServer();
        $htmlMessageMail = 'login= ' . $login . '  mot de passe = ' . $pwd . '  ';



        $message->addTo($mail)
                ->addFrom('yeferniibtihel@gmail.com')
                ->setSubject('test')
                ->setBody($htmlMessageMail);
        $message->setEncoding('UTF-8');
        $transport->send($message);
        return 1;
    }

    public function verifformapwd($pwd) {

        $tabe1 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'y', 'x', 'z');
        $tabe2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $tabe3 = array('!', '@', '#', '$', '%', '^', '&', '*', '-', '_', '=', '+', ';', ':', '.', ',', '<', '>', '/', '?');
        $tabe4 = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $nbr_caracterepwd = strlen($pwd);
        $nbr_caracteretabe1 = count($tabe1);
        $arr = str_split($pwd);
        $existeTab1 = 0;
        $existeTab2 = 0;
        $existeTab3 = 0;
        $existeTab4 = 0;

        for ($i = 0; $i < $nbr_caracterepwd; $i++) {
            if (in_array($arr[$i], $tabe1)) {
                $existeTab1 = $existeTab1 + 1;
                break;
            }
        }
        for ($i = 0; $i < $nbr_caracterepwd; $i++) {
            if (in_array($arr[$i], $tabe2)) {
                $existeTab2 = 1;
                break;
            }
        }
        for ($i = 0; $i < $nbr_caracterepwd; $i++) {
            if (in_array($arr[$i], $tabe3)) {
                $existeTab3 = 1;
                break;
            }
        }
        for ($i = 0; $i < $nbr_caracterepwd; $i++) {
            if (in_array($arr[$i], $tabe4)) {
                $existeTab4 = 1;
                break;
            }
        }
        $pwdisValid = 0;
        $sommevalidation = $existeTab1 + $existeTab2 + $existeTab3 + $existeTab4;
        if ($sommevalidation == "4")
            $pwdisValid = 1;
        return $pwdisValid;
    }

    public function generatePWD() {

        $tabe1 = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'y', 'x', 'z');
        $tabe2 = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $tabe3 = array('!', '@', '#', '$', '%', '^', '&', '*', '-', '_', '=', '+', ';', ':', '.', ',', '<', '>', '/', '?');
        $tabe4 = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
        $pass = '';
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, count($tabe1));
            $pass = $pass . $tabe1[$n];
        }
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, count($tabe2));
            $pass = $pass . $tabe2[$n];
        }
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, count($tabe3));
            $pass = $pass . $tabe3[$n];
        }
        for ($i = 0; $i < 2; $i++) {
            $n = rand(0, count($tabe4));
            $pass = $pass . $tabe4[$n];
        }
        return $pass;
    }

    public function editpwdAction() {
        $userContainer = new Container('user');
        $user = $userContainer->utilisateur;
        if (!$userContainer->utilisateur) {
            return $this->redirect()->toUrl('/');
        }
        $user = new GestionUser();
        $user = $userContainer->utilisateur;
        $id = $user->idUser;
        $user = $this->getGestionUserTable()->getGestionUser($id);

        $form = new pwdForm();

        $form->get('submit')->setAttribute('value', 'Confirmer');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            $postdata = $request->getPost();

            $pwd = $postdata['pwd'];

            $hashedPwd = hash('sha256', $pwd);
            $actuel = strcmp($hashedPwd, $user->pwd);


            if ($actuel == 0) {

                $pwd1 = $postdata['pwd1'];
                $pwd2 = $postdata['pwd2'];
                $valider = strcmp($pwd1, $pwd2);

                if ($valider == 0) {

                    //v??rification du longueur
                    $veriflong = strlen($pwd2);
                    if ($veriflong < 8) {

                        $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                            'messageErreur' => "true", 'message' => "Mot de passe trop court , il doit avoir au moins 8 caract??res."));

                        return $view;
                    }
                    //--------------------------
                    //v??rification du format 
                    if ($this->verifformapwd($pwd1) == 1) {

                        $user->pwd = $pwd2;

                        $this->getGestionUserTable()->saveGestionUser($user);


                        $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                            'success' => "true", 'messageSuccess' => "Votre mot de passe a ??t?? modifi??."));
                        return $view;
                    } else {
                        $view = new ViewModel(array('idUser' => $id, 'form' => $form, 'messageErreur' => "true",
                            'message' => "Le mot de passe doit contenir des lettres en miniscules, majuscules, sp??ciaux et des nombres"));

                        return $view;
                    }
                    //------------
                } else {
                    $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                        'messageErreur' => "true", 'message' => "Mots de passe ne sont pas identiques."));

                    return $view;
                }
            } else {
                $view = new ViewModel(array('idUser' => $id, 'form' => $form,
                    'messageErreur' => "true", 'message' => "Mot de passe actuel est invalide"));

                return $view;
            }

            $view = new ViewModel(array('idUser' => $id, 'form' => $form));

            return $view;
        }

        $view = new ViewModel(array('idUser' => $id, 'form' => $form));

        return $view;
    }

}
