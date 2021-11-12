<?php

namespace Lists\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Db\Sql\Sql;

class ListsTable extends AbstractTableGateway {

    protected $table = 'list';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Lists());

        $this->initialize();
    }

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getListeLists() {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'l.list_idDelegation = d.id', array('nomDelegation' => 'nom', 'nomArabDelegation' => 'nomArabe'))
                ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id', array('nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        return $results;
        /*$resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

         

          return $resTable;*/
          //return $results; 
    }
    
    public function getListeListscord($list) {
        
        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'l.list_idDelegation = d.id', array('nomDelegation' => 'nom', 'nomArabDelegation' => 'nomArabe'))
                ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id ', array('nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $select->where(array('d.idGouvernorat'=> $list));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
       
        return $results;
        /*$resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

         

          return $resTable;*/
          //return $results; 
    }
    
     public function getListeListsSuper($list) {
        
        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'l.list_idDelegation = d.id', array('nomDelegation' => 'nom', 'nomArabDelegation' => 'nomArabe'))
                ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id ', array('nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $select->where(array('d.id'=> $list));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
       
        return $results;
        
    }
    
    
      public function getListeListsByIdws($id) {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
     //   $select->columns(array('d.list_id', 'd.list_nom', 'd.list_tete', 'd.list_image', 'd.list_logo', 'd.list_imageGroup' => 'd.list_type', 'd.list_valide' => 'd.list_publie'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'd.id = l.list_idDelegation', array('nomDelegation' => 'nom', 'nomArabeDelegation' => 'nomArabe'));
         $select->where(array('list_id' => $id));
        // $select->where(array('	list_publie' => 1));
        
        $selectString = $sql->getSqlStringForSqlObject($select);
       // print_r($selectString);exit;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         
       // return $results;
       $resTable = array();
        $baseUrl='http://baladity-2018.tn';
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $tabs=json_decode($resObject, 1);
          if($tabs['list_image']){
             $tabs['list_image']= $baseUrl.'/assets/imageList/'.$tabs['list_image'];
          }
          if($tabs['list_logo']){
             $tabs['list_logo']= $baseUrl.'/assets/logo/'.$tabs['list_logo'];
          }
          if($tabs['list_imageGroup']){
             $tabs['list_imageGroup']= $baseUrl.'/assets/imageListGroup/'.$tabs['list_imageGroup'];
          }
          
          $resTable[] = $tabs;
          }
          
          echo json_encode($resTable);
          exit;

          echo '<pre>';
          print_r($resTable);exit;

          return $resTable;
          return $results;
    }
    
    

	  public function getListeListsws($id,$type) {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
     //   $select->columns(array('d.list_id', 'd.list_nom', 'd.list_tete', 'd.list_image', 'd.list_logo', 'd.list_imageGroup' => 'd.list_type', 'd.list_valide' => 'd.list_publie'));
        $select->from(array('l' => 'list'))
                ->join(array('d' => 'delegation'), 'd.id = l.list_idDelegation', array('nomDelegation' => 'nom', 'nomArabeDelegation' => 'nomArabe'));
         $select->where(array('list_idDelegation' => $id));
         $select->where(array('list_valide' => 0));
         $select->where(array('list_publie' => 0));
        // $select->where(array('	list_publie' => 1));
        if($type){
             $select->where(array('list_type' => $type)); 
         }
        $selectString = $sql->getSqlStringForSqlObject($select);
       // print_r($selectString);exit;
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
         
       // return $results;
       $resTable = array();
        $baseUrl='http://baladity-2018.tn';
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $tabs=json_decode($resObject, 1);
          if($tabs['list_image']){
             $tabs['list_image']= $baseUrl.'/assets/imageList/'.$tabs['list_image'];
          }
          if($tabs['list_logo']){
             $tabs['list_logo']= $baseUrl.'/assets/logo/'.$tabs['list_logo'];
          }
          if($tabs['list_imageGroup']){
             $tabs['list_imageGroup']= $baseUrl.'/assets/imageListGroup/'.$tabs['list_imageGroup'];
          }
          
          $resTable[] = $tabs;
          }
          
          echo json_encode($resTable);
          exit;

          echo '<pre>';
          print_r($resTable);exit;

          return $resTable;
          return $results;
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
    
    
     public function getListeListsDelegationByIdGouvernorat($id) {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from('delegation');
        $select->where(array('idGouvernorat' => $id));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
        $resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

          return $resTable;
         
    }
    
    public function getDelegationById($id) {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('*'));
        $select->from('delegation');
        $select->where(array('id' => $id));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        
         /*return $results;*/
        
       $resTable = array();
        
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

          return $resTable;
         
    }

    public function getLists($id) {
        $id = (int) $id;
        $rowset = $this->select(array('list_id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveLists(Lists $list) {
        $data = array(
            'list_nom' => $list->list_nom,
            'list_num' => $list->list_num,
            'list_tete' => $list->list_tete,
            'list_image' => $list->list_image,
            'list_imageGroup' => $list->list_imageGroup,
            'list_type' => $list->list_type,
            'list_valide' => $list->list_valide,
            'list_dateValide' => $list->list_dateValide,
            'list_userValide' => $list->list_userValide,
            'list_publie' => $list->list_publie,
            'list_datePublie' => $list->list_datePublie,
            'list_userPublie' => $list->list_userPublie,
            'list_deate_creation' => $list->list_deate_creation,
             'list_userCreate' => $list->list_userCreate,
            'list_logo' => $list->list_logo,
             'list_idDelegation' => $list->list_idDelegation,
        );
        $id = (int) $list->list_id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getLists($id)) {
                $this->update($data, array('list_id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteLists($id) {
        $this->delete(array('list_id' => (int) $id));
    }

}
