<?php

namespace GestionUser\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Db\Sql\Sql;

class GestionUserTable extends AbstractTableGateway {

    protected $table = 'user';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new GestionUser());

        $this->initialize();
    }

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
    }
    
    
     public function getListeListsSuper($list) {
        
        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'l.list_idDelegation = d.id', array('nomDelegation' => 'nom', 'nomArabDelegation' => 'nomArabe'))
                ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id ', array('nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $select->where(array('l.list_idDelegation'=> $list));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
      //  return $results;
        $resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

         

          return $resTable;
       
       // return $results;
        
    }
    
    
         public function getListeDelegationSuper($list) {
      
        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('id','nom','nomArabe','deate_creation','idGouvernorat','nomGouvernorat'=>'nom'  ,'nomArabeGouvernorat'=>'nomArabe'));
        $select->from(array('d' =>'delegation'))
           ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id',
                   array('nomGouvernorat' => 'nom','nomArabeGouvernorat' => 'nomArabe'));
         $select->where(array('d.id'=> $list));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
       // return $results;
         $resTable = array();
         
        foreach ($results as $res) {
            $resObject = json_encode($res);
            $resTable[] = json_decode($resObject, 1);
        }
       return $resTable;
       
        
     }
    
    
    public function getListeDelegation() {
      
        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('id','nom','nomArabe','deate_creation','idGouvernorat','nomGouvernorat'=>'nom'  ,'nomArabeGouvernorat'=>'nomArabe'));
        $select->from(array('d' =>'delegation'))
           ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id',
                   array('nomGouvernorat' => 'nom','nomArabeGouvernorat' => 'nomArabe'));
        $select->order('idGouvernorat ASC'); 
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
        $resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

         

        return $resTable;
         //$resTable = array();
         
        
     }

    public function getGestionUser($id) {
        $id = (int) $id;
        $rowset = $this->select(array('idUser' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function getUserByEmail($email) {

        $rowset = $this->select(array('mailUser' => $email));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;
    }

    public function connection($login, $pwd) {
        $rowset = $this->select(array('login' => $login, 'pwd' => hash('sha256', $pwd)));
        $row = $rowset->current();
        if (!$row) {
            return NULL;
        }
        return $row;

        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->from('user');
        $select->where(array('idUser' => '2'));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;
    }

    public function saveGestionUser(GestionUser $user) {
        if ($user->idUser != null) {
            $data['idUser'] = $user->idUser;
        }

        if ($user->nomUser != null) {
            $data['nomUser'] = $user->nomUser;
        }
        if ($user->prenomUser != null) {
            $data['prenomUser'] = $user->prenomUser;
        }
        if ($user->mailUser != null) {
            $data['mailUser'] = $user->mailUser;
        }
        if ($user->adresseUser != null) {
            $data['adresseUser'] = $user->adresseUser;
        }
        if ($user->dateNaisUser != null) {
            $data['dateNaisUser'] = $user->dateNaisUser;
        }
        if ($user->lieuNaisUser != null) {
            $data['lieuNaisUser'] = $user->lieuNaisUser;
        }

        if ($user->telUser != null) {
            $data['telUser'] = $user->telUser;
        }
        if ($user->image != null) {
            $data['image'] = $user->image;
        }
        if ($user->login != null) {
            $data['login'] = $user->login;
        }
        if ($user->pwd != null) {
            $data['pwd'] = $hashedPassword = hash('sha256', $user->pwd);
            ;
        }
        if ($user->pwdc != null) {
            $data['pwdc'] = $user->pwdc;
        }
         if ($user->delegations != null) {
            $data['delegations'] = $user->delegations;
        }
        
         if ($user->gouvernorat != null) {
            $data['gouvernorat'] = $user->gouvernorat;
        }
        
        if ($user->isAdmin != null) {
            $data['isAdmin'] = $user->isAdmin;
        }
        if ($user->etat != null) {
            $data['etat'] = $user->etat;
        }


        /*   $data = array(
          'nomUser' => $user->nomUser,
          'prenomUser'  => $user->prenomUser,
          'mailUser'  => $user->mailUser,
          'adresseUser'  => $user->adresseUser,
          'dateNaisUser'  => $user->dateNaisUser,
          'lieuNaisUser'  => $user->lieuNaisUser,
          'telUser'  => $user->telUser,
          'image'  => $user->image,
          'login'  => $user->login,
          'pwd'  => $hashedPassword,

          'isAdmin'  => $user->isAdmin,
          'etat'  => $user->etat,

          ); */

        $id = (int) $user->idUser;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getGestionUser($id)) {
                $this->update($data, array('idUser' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteGestionUser($id) {
        $this->delete(array('idUser' => (int) $id));
    }

    public function savePWD(GestionUser $user) {

        $data = array(
            'pwd' => $user->pwd,
        );
        $id = (int) $user->idUser;
        if ($this->getGestionUser($id)) {
            $this->update($data, array('idUser' => $id));
        } else {
            throw new \Exception('Form id does not exist');
        }
    }
    
    
      public function getListeListsGouvernorat() {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from('gouvernorat');
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
        $resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

          return $resTable;
         
    }

}
