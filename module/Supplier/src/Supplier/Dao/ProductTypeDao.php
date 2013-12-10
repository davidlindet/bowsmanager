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

use Supplier\Model\ProductType;

class ProductTypeDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = new Select();
        $select->from("bm_product_type");
        $select->order('id ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function getProductType($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProductType(ProductType $productType)
    {
        $data = array(
            'name' => $productType->getName(),
        );

        $id = (int)$productType->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getProductType($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('ProductType id does not exist');
            }
        }
        return $id;

    }

    public function deleteProductType($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}