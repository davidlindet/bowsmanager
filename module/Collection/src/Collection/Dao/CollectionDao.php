<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Dao;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\ResultSet\ResultSet;

use Collection\Model\Collection;
use Collection\Enum\CollectionEnum;

class CollectionDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($order = CollectionEnum::SORT_NEW_TO_OLD) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        if($order == CollectionEnum::SORT_NEW_TO_OLD){
            $orderSql = "reception_time DESC";
        }
        elseif($order == CollectionEnum::SORT_OLD_TO_NEW){
            $orderSql = "reception_time ASC";
        }

        $sql = "SELECT col.id, owner, reception_time, sent_status, paid_status, first_name, last_name
              FROM collection col
              JOIN client cli
              ON cli.id = col.owner
              ORDER BY $orderSql;
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $collections = array();
        foreach($resultSet as $data){
            $collection = new Collection();
            $collection->exchangeArray($data);
            $collections[] = $collection;
        }
        return $collections;
    }

    public function fetchAllByOwner($ownerId, $order = CollectionEnum::SORT_NEW_TO_OLD) {
        $select = new Select();
        $select->from("collection");
        $select->where(array('owner' => $ownerId));
        if($order == CollectionEnum::SORT_NEW_TO_OLD){
            $select->order('reception_time DESC');
        }
        elseif($order == CollectionEnum::SORT_OLD_TO_NEW){
            $select->order('reception_time ASC');
        }
        $resultSet = $this->tableGateway->selectWith($select);
        $collections = array();
        foreach($resultSet as $collection){
            $collections[] = $collection;
        }
        return $collections;
    }

    public function getCollection($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCollection(Collection $collection)
    {
        $data = array(
            'owner' => $collection->getOwner(),
            'reception_time'  => $collection->getReceptionTime(),
            'return_time' => $collection->getReturnTime(),
            'package_number'  => $collection->getPackageNumber(),
            'bill_reference'  => $collection->getBillReference(),
            'bill_amount'  => $collection->getBillAmount(),
            'paid_status'  => $collection->getPaidStatus(),
        );

        $id = (int) $collection->getId();
        if ($id == CollectionEnum::NEW_COLLECTION) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getCollection($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            }
            else {
                throw new \Exception('Collection id does not exist');
            }
        }
        return $id;
    }

    public function deleteCollection($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}