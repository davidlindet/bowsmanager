<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Bill\Dao;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

use Bill\Model\Bill;

class BillDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = new Select();
        $select->from("bm_bill");
        $select->order('reference DESC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getBillsNotPaid(){

        $driver = $this->tableGateway->getAdapter()->getDriver();

        $sql = "SELECT *
                FROM  bm_bill
                WHERE is_paid = FALSE
              ORDER BY id DESC;
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $bills = array();
        foreach($resultSet as $data){
            $bill = new Bill();
            $bill->exchangeArray($data);
            $bills[] = $bill;
        }

        return $bills;
    }

    public function fetchAllByCollection($collectionId)
    {
        $select = new Select();
        $select->from("bm_bill");
        $select->where(array('collection_id' => $collectionId));
        $select->order('id ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        $bills = array();
        /** @var $bill Bill */
        foreach($resultSet as $bill){
            $bills[$bill->getId()] = $bill;
        }
        return $bills;
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

    public function getBill($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBill(Bill $bill)
    {
        $data = array(
            'collection_id' => $bill->getCollectionId(),
            'amount' => $bill->getAmount(),
            'reference'  => $bill->getReference(),
            'is_paid' => $bill->isPaid(),
            'payment_type' => $bill->getPaymentType(),
            'attachments'  =>  $bill->hasAttachments() ? implode("--", $bill->getAttachments()) : "",
        );

        $id = (int)$bill->getId();
        if ($id == 0) {
            $data['creation_time'] = time();
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getBill($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Bill id does not exist');
            }
        }
        return $id;

    }

    public function deleteBill($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}