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

use Bow\Model\Bow;

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
            'type' => $bow->getType(),
            'size'  => $bow->getSize(),
            'description'  => $bow->getDescription(),
            'work_to_do'  => $bow->getWorkToDo(),
            'status'  => $bow->getStatus(),
            'is_done'  => $bow->getIsDone(),
            'comments'  => $bow->getComments(),
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