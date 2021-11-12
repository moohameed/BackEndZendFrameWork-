<?php

namespace Logo\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Db\Sql\Sql;

class LogoTable extends AbstractTableGateway {

    protected $table = 'logo';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Logo());

        $this->initialize();
    }

    public function fetchAll() {
        $resultSet = $this->select();
        return $resultSet;
    }

    public function getLogo($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveLogo(Logo $logo) {
        $data = array(
            'nom' => $logo->nom,
            'url' => $logo->url,
            'deate_creation' => $logo->deate_creation,
        );
        $id = (int) $logo->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getLogo($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteLogo($id) {
        
       
        $this->delete(array('id' => (int) $id));
    }

}
