<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\RegistrationFilter;
use Application\Form\RegistrationForm;
use Application\Form\RegistrationwsForm;
use Application\Form\PwdnewFilter;
use Application\Form\PwdnewForm;
use Zend\Mail\Message;
use Zend\Session\Container;
use GestionUser\Model\GestionUser;
use GestionUser\Controller\GestionUserController as GestionUserController;

class IndexController extends AbstractActionController {

    protected $userTable;

    public function indexAction() {

        $form = new RegistrationForm();
        $form->get('submit')->setValue('Valider');
        $view = new ViewModel(array('form' => $form));
        $view->setTerminal(true);
        $request = $this->getRequest();
        if ($request->isPost()) {




            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $postdata = $request->getPost();

                $login = $postdata['usr_login'];
                $pwd = $postdata['usr_password'];

                $user = $this->getGestionUserTable()->connection($login, $pwd);

                if ($user) {

                    $userContainer = new Container('user');
                    $userContainer->utilisateur = $user;

                    return $this->redirect()->toUrl('/user/profil');
                } else {

                    $view = new ViewModel(array('form' => $form, 'messageErreur' => "true", 'message' => "Login ou mot de passe invalide."));
                    $view->setTerminal(true);
                }


                $data = $form->getData();
            } else {
                $view = new ViewModel(array('form' => $form, 'messageErreur' => "true", 'message' => "Certains paramètres sont invalides."));
                $view->setTerminal(true);
            }
        }

        return $view;
    }

    public function autowsAction() {



        $form = new RegistrationwsForm();


        $request = $this->getRequest();
        if ($request->isPost()) {


            $form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {

                $postdata = $request->getPost();

                $login = $postdata['usr_login'];
                $pwd = $postdata['usr_password'];

                $user = $this->getGestionUserTable()->connection($login, $pwd);

                if ($user) {

                    $userContainer = new Container('user');
                    $userContainer->utilisateur = $user;

                    $listedelegation = $this->getGestionUserTable()->getListeDelegationSuper(json_decode($user->delegations, 1));

                    $userr = json_decode(json_encode($user), 1);



                    echo json_encode(array('user' => $userr, 'delegation' => $listedelegation));

                    exit;
                } else {
                     echo json_encode(array('state'=>0,'msg'=>"Login ou mot de passe invalide."));
                   // echo "Login ou mot de passe invalide.";
                    exit;
                }


                $data = $form->getData();
            } else {
               // echo "Certains paramètres sont invalides.";
                 echo json_encode(array('state'=>0,'msg'=>"Certains paramètres sont invalides."));
                exit;
            }
        }

        exit;
    }

    public function deconnectionAction() {


        $session_user = new Container("user");
        $session_user->getManager()->getStorage()->clear();
        return $this->redirect()->toUrl('/');
    }

    public function pwdoublieAction() {
        $form = new PwdnewForm();
        $view = new ViewModel(array('form' => $form));


        $request = $this->getRequest();
        if ($request->isPost()) {

            $user = new GestionUser();
            // $form->setInputFilter(new PwdnewFilter($this->getServiceLocator()));

            $form->setData($request->getPost());
            if ($form->isValid()) {

                $postdata = $request->getPost();

                $email = $postdata['mailUser'];


                $user = $this->getGestionUserTable()->getUserByEmail($email);

                if ($user) {

                    $usercontorl = new GestionUserController();
                    $pwd = $usercontorl->generatePWD();


                    $user->pwd = $pwd;
                    // echo '----->'.$pwd.'<-----';

                    $this->getGestionUserTable()->saveGestionUser($user);

                    $this->envoieMail($user->nomUser, $user->prenomUser, $user->login, $user->mailUser, $pwd);




                    $view = new ViewModel(array('form' => '', 'success' => "true", 'messageSuccess' => "Votre mot de passe a été modifié."));
                    $view->setTerminal(true);

                    return $view;
                } else {

                    $view = new ViewModel(array('form' => $form, 'messageErreur' => "true", 'message' => "Certains paramètres sont invalides."));
                    $view->setTerminal(true);
                    return $view;
                }


                return $this->redirect()->toRoute('user');
            }

            return array('form' => $form);
        }






        $view->setTerminal(true);
        return $view;
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

}
