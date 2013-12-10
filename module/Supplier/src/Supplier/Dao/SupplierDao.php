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
        $select->order('id ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }


//    public function fetchAllByQuery($query) {
//        $driver = $this->tableGateway->getAdapter()->getDriver();
//
//        $sql = false;
//
//        if(strtolower($query) == strtolower(BillTypeEnum::COPY(BillTypeEnum::ALTO))){
//            $sql =   "SELECT * FROM bm_bill b WHERE b.type = " . BillTypeEnum::ALTO;
//        }
//        elseif(strtolower($query) == strtolower(BillTypeEnum::COPY(BillTypeEnum::CELLO))){
//            $sql =   "SELECT * FROM bm_bill b WHERE b.type = " . BillTypeEnum::CELLO;
//        }
//        elseif(strtolower($query) == strtolower(BillTypeEnum::COPY(BillTypeEnum::VIOLIN))){
//            $sql =   "SELECT * FROM bm_bill b WHERE b.type = " . BillTypeEnum::VIOLIN;
//        }
//        elseif(strtolower($query) == strtolower(BillTypeEnum::COPY(BillTypeEnum::DOUBLE_BASS))){
//            $sql =   "SELECT * FROM bm_bill b WHERE b.type = " . BillTypeEnum::DOUBLE_BASS;
//        }
//
//        if(!$sql) {
//            $sql = "SELECT * FROM bm_bill WHERE description LIKE '%$query%'
//                    UNION
//                    SELECT * FROM bm_bill WHERE work_to_do LIKE '%$query%'
//                    UNION
//                    SELECT * FROM bm_bill WHERE status LIKE '%$query%'
//                    UNION
//                    SELECT * FROM bm_bill WHERE comments LIKE '%$query%'
//            ";
//        }
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
        $data = array();
//        $data = array(
//            'collection_id' => $bill->getCollectionId(),
//            'amount' => $bill->getAmount(),
//            'reference'  => $bill->getReference(),
//            'is_paid' => $bill->isPaid(),
//            'attachments'  =>  $bill->hasAttachments() ? implode("--", $bill->getAttachments()) : "",
//        );

        $id = (int)$supplier->getId();
        if ($id == 0) {
            $data['creation_time'] = time();
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