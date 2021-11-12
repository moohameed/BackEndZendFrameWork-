<?php

namespace Delegation\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Db\Sql\Sql;

class DelegationTable extends AbstractTableGateway {

    protected $table = 'delegation';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Delegation());

        $this->initialize();
    }

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
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

    public function getListeDelegation() {

        $adapter = $this->adapter;
        $sql = new Sql($this->adapter);
        $select = $sql->select();
        $select->columns(array('id', 'nom', 'nomArabe', 'nbrChaise', 'deate_creation', 'idGouvernorat', 'nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $select->from(array('d' => 'delegation'))
                ->join(array('g' => 'gouvernorat'), 'd.idGouvernorat = g.id', array('nomGouvernorat' => 'nom', 'nomArabeGouvernorat' => 'nomArabe'));
        $selectString = $sql->getSqlStringForSqlObject($select);
        $results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
        return $results;
        $resTable = array();
        /*
          foreach ($results as $res) {
          $resObject = json_encode($res);
          $resTable[] = json_decode($resObject, 1);
          }

          echo '<pre>';
          print_r($resTable);exit;

          return $resTable;
          return $results; */
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

        return json_encode($resTable);
    }

    public function getDelegation($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveDelegation(Delegation $delegation) {
        $data = array(
            'nom' => $delegation->nom,
            'nomArabe' => $delegation->nomArabe,
            'nbrChaise' => $delegation->nbrChaise,
            'deate_creation' => $delegation->deate_creation,
            'idGouvernorat' => $delegation->idGouvernorat,
        );
        $id = (int) $delegation->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getDelegation($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteDelegation($id) {
        $this->delete(array('id' => (int) $id));
    }

}
