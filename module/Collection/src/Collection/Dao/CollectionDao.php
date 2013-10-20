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

use Collection\Model\Collection;
use Collection\Enum\CollectionEnum;

class CollectionDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll() {
        $select = new Select();
        $select->from("collection");
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function fetchAllByOwner($ownerId) {
        $select = new Select();
        $select->from("collection");
        $select->where(array('owner' => $ownerId));
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
            'sent_status'  => $collection->getSentStatus(),
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