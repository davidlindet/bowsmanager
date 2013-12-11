<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Dao;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

use Supplier\Model\Supplier;

class SupplierDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = new Select();
        $select->from("bm_supplier");
        $select->order('name ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

//    public function fetchAllByQuery($query) {
//        $driver = $this->tableGateway->getAdapter()->getDriver();
//
//        $sql = false;
//
//        $statement = $driver->createStatement($sql);
//        $result = $statement->execute();
//
//        $resultSet = new ResultSet;
//        $resultSet->initialize($result);
//
//        $bills = array();
//        foreach($resultSet as $data){
//            $bill = new Bill();
//            $bill->exchangeArray($data);
//            $bills[$bill->getId()] = $bill;
//        }
//        return $bills;
//    }

    public function getSupplier($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveSupplier(Supplier $supplier)
    {
        $data = array(
            'name' => $supplier->getName(),
            'address' => $supplier->getAddress(),
            'phone'  => $supplier->getPhone(),
            'email' => $supplier->getEmail(),
            'website'  => $supplier->getWebsite(),
        );

        $id = (int)$supplier->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getSupplier($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Supplier id does not exist');
            }
        }
        return $id;

    }

    public function deleteSupplier($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}