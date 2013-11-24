<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Bow\Dao;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

use Bow\Model\Bow;
use Bow\Enum\BowTypeEnum;

class BowDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetchAllByCollection($collectionId)
    {
        $select = new Select();
        $select->from("bm_bow");
        $select->where(array('collection_id' => $collectionId));
        $select->order('id ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        $bows = array();
        /** @var $bow Bow */
        foreach($resultSet as $bow){
            $bows[$bow->getId()] = $bow;
        }
        return $bows;
    }

    public function fetchAllByQuery($query) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        $sql = false;

        if(strtolower($query) == strtolower(BowTypeEnum::COPY(BowTypeEnum::ALTO))){
            $sql =   "SELECT * FROM bm_bow b WHERE b.type = " . BowTypeEnum::ALTO;
        }
        elseif(strtolower($query) == strtolower(BowTypeEnum::COPY(BowTypeEnum::CELLO))){
            $sql =   "SELECT * FROM bm_bow b WHERE b.type = " . BowTypeEnum::CELLO;
        }
        elseif(strtolower($query) == strtolower(BowTypeEnum::COPY(BowTypeEnum::VIOLIN))){
            $sql =   "SELECT * FROM bm_bow b WHERE b.type = " . BowTypeEnum::VIOLIN;
        }
        elseif(strtolower($query) == strtolower(BowTypeEnum::COPY(BowTypeEnum::DOUBLE_BASS))){
            $sql =   "SELECT * FROM bm_bow b WHERE b.type = " . BowTypeEnum::DOUBLE_BASS;
        }

        if(!$sql) {
            $sql = "SELECT * FROM bm_bow WHERE description LIKE '%$query%'
                    UNION
                    SELECT * FROM bm_bow WHERE work_to_do LIKE '%$query%'
                    UNION
                    SELECT * FROM bm_bow WHERE status LIKE '%$query%'
                    UNION
                    SELECT * FROM bm_bow WHERE comments LIKE '%$query%'
            ";
        }

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $bows = array();
        foreach($resultSet as $data){
            $bow = new Bow();
            $bow->exchangeArray($data);
            $bows[$bow->getId()] = $bow;
        }
        return $bows;
    }

    public function getBow($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveBow(Bow $bow)
    {
        $data = array(
            'number' => $bow->getNumber(),
            'collection_id' => $bow->getCollectionId(),
            'type' => $bow->getType(),
            'size'  => $bow->getSize(),
            'description'  => $bow->getDescription(),
            'work_to_do'  => $bow->getWorkToDo(),
            'status'  => $bow->getStatus(),
            'is_done'  => $bow->getIsDone(),
            'comments'  => $bow->getComments(),
            'attachments'  =>  $bow->hasAttachments() ? implode("--", $bow->getAttachments()) : "",
        );

        $id = (int)$bow->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getBow($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Bow id does not exist');
            }
        }
        return $id;

    }

    public function deleteBow($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}