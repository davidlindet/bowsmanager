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

    public function fetchAll($order = CollectionEnum::SORT_NEW_TO_OLD, $where = array()) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        if($order == CollectionEnum::SORT_NEW_TO_OLD){
            $orderSql = "reception_time DESC";
        }
        elseif($order == CollectionEnum::SORT_OLD_TO_NEW){
            $orderSql = "reception_time ASC";
        }

        $whereSql = (empty($where)) ? "" : "WHERE ";
        for($i = 0; $i < count($where); $i++){
            $data = $where[$i];
            $whereSql .= $data['key'] . $data['clause'] . $data['value'];

            if($i < count($where) -1){
                $whereSql .= " AND ";
            }
        }

        $sql = "SELECT col.id, owner, reception_time, return_time,
              package_number, bill_reference, bill_amount,
              paid_status, first_name, last_name
              FROM bm_collection col
                  JOIN bm_client cli
                    ON cli.id = col.owner
              $whereSql
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
            $collections[$collection->getId()] = $collection;
        }
        return $collections;
    }

    public function fetchAllByQuery($query, $order = CollectionEnum::SORT_NEW_TO_OLD) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        if($order == CollectionEnum::SORT_NEW_TO_OLD){
            $orderSql = "reception_time DESC";
        }
        elseif($order == CollectionEnum::SORT_OLD_TO_NEW){
            $orderSql = "reception_time ASC";
        }

        $columns = "col.id, owner, reception_time, return_time, package_number, bill_reference, bill_amount, paid_status, first_name, last_name";
        $sql = "SELECT $columns FROM bm_collection col, bm_client cli WHERE col.owner = cli.id AND
                    (owner) IN (SELECT id FROM bm_client WHERE last_name LIKE'%$query%')
                UNION
                SELECT $columns
                    FROM bm_collection col, bm_client cli
                    WHERE col.owner = cli.id
                      AND package_number LIKE '%$query%'
                UNION
                SELECT $columns
                    FROM bm_collection col, bm_client cli
                    WHERE col.owner = cli.id
                      AND bill_reference LIKE '%$query%'
                    ORDER BY $orderSql
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $collections = array();
        foreach($resultSet as $data){
            $collection = new Collection();
            $collection->exchangeArray($data);
            $collections[$collection->getId()] = $collection;
        }
        return $collections;
    }

    public function fetchAllByOwner($ownerId, $order = CollectionEnum::SORT_NEW_TO_OLD) {
        $select = new Select();
        $select->from("bm_collection");
        $select->where(array('owner' => $ownerId));
        if($order == CollectionEnum::SORT_NEW_TO_OLD){
            $select->order('reception_time DESC');
        }
        elseif($order == CollectionEnum::SORT_OLD_TO_NEW){
            $select->order('reception_time ASC');
        }
        $resultSet = $this->tableGateway->selectWith($select);
        $collections = array();
        /** @var $collection Collection */
        foreach($resultSet as $collection){
            $collections[$collection->getId()] = $collection;
        }
        return $collections;
    }

    public function getCollection($id)
    {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        $sql = "SELECT col.id, owner, reception_time, return_time,
              package_number, bill_reference, bill_amount,
              paid_status, first_name, last_name
              FROM bm_collection col
              JOIN bm_client cli
                  ON cli.id = col.owner
              WHERE col.id = $id;
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $data = $resultSet->current();

        if (!$data) {
            throw new \Exception("Could not find row $id");
        }

        $collection = new Collection();
        $collection->exchangeArray($data);
        return $collection;
    }

    public function saveCollection(Collection $collection)
    {
        $data = array(
            'owner' => $collection->getOwnerId(),
            'reception_time'  => $collection->getReceptionTime(false),
            'return_time' => $collection->getReturnTime(false),
            'package_number'  => $collection->getPackageNumber(),
            'bill_reference'  => $collection->getBillReference(),
            'bill_amount'  => $collection->getBillAmount(),
            'paid_status'  => $collection->isPaid(),
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