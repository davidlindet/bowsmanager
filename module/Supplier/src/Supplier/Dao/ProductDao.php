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

use Supplier\Model\Product;

class ProductDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $select = new Select();
        $select->from("bm_product");
        $select->order('id ASC');
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    public function fetchAllByProductType($type)
    {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        $where = $type ? "AND prod.product_type = $type": "";

        $sql = "SELECT prod.id, supplier_id, sup.name AS supplier_name,
              product_type, prod_type.name AS type_name,
              prod.name AS name, reference, price, devise
              FROM bm_product prod, bm_supplier sup, bm_product_type prod_type
              WHERE prod.supplier_id = sup.id AND prod.product_type = prod_type.id $where
              ORDER BY sup.name;
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $products = array();
        foreach($resultSet as $data){
            $product = new Product();
            $product->exchangeArray($data);
            $products[$product->getId()] = $product;
        }
        return $products;
    }

    public function getProduct($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProduct(Product $product)
    {
        $data = array(
            'supplier_id' => $product->getSupplierId(),
            'product_type' => $product->getProductType(),
            'name' => $product->getName(),
            'reference' => $product->getReference(),
            'price' => (float) $product->getPrice(),
            'devise' => $product->getDevise(),
        );

        $id = (int)$product->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getProduct($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Product id does not exist');
            }
        }
        return $id;

    }

    public function deleteProduct($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}