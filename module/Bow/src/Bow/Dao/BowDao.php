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
            'type' => $bow->type,
            'size'  => $bow->size,
            'description'  => $bow->description,
            'work_to_do'  => $bow->workToDo,
            'status'  => $bow->status,
            'is_done'  => $bow->isDone,
            'comments'  => $bow->comments,
        );

        $id = (int)$bow->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBow($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Album id does not exist');
            }
        }
    }

    public function deleteBow($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}