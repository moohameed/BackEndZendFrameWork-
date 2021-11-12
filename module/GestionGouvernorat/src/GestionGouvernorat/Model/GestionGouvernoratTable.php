<?php

namespace GestionGouvernorat\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Db\Sql\Sql;



class GestionGouvernoratTable extends AbstractTableGateway
{
    protected $table = 'gouvernorat';

      public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new GestionGouvernorat());

        $this->initialize();
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

          return json_encode($resTable);
         
    }

    public function fetchAll()
    {
        $resultSet = $this->select();
         return $resultSet;
    }

    public function getGestionGouvernorat($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }
    
 
  
    
    public function saveGestionGouvernorat(GestionGouvernorat $user)
    {         
         if($user->id!=null){
           $data['id'] = $user->id;
        }
        
        if($user->nom!=null){
           $data['nom'] = $user->nom;
        }
          if($user->code!=null){
           $data['code'] = $user->code;
        }
          if($user->date_creation!=null){
           $data['date_creation'] = $user->date_creation;
        }
          if($user->carte!=null){
           $data['carte'] = $user->carte;
        }
          if($user->nomArabe!=null){
           $data['nomArabe'] = $user->nomArabe;
        }
         
       
        $id = (int)$user->id;
        if ($id == 0) {
          $this->insert($data);
        } else {
            if ($this->getGestionGouvernorat($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }  
    
    public function deleteGestionGouvernorat($id)
    {
         $this->delete(array('id' => (int) $id));
    }
    

        
     
     
     
            }
         
     
