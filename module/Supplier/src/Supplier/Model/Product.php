<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Model;

class Product
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $supplierId;

    /**
     * @var String
     */
    private $supplierName;

    /**
     * @var int
     */
    private $productType;

    /**
     * @var String
     */
    private $typeName;

    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $reference;

    /**
     * @var float
     */
    private $price;

    /**
     * @var int
     */
    private $devise;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
        $this->supplierId = (isset($data['supplier_id'])) ? (int) $data['supplier_id'] : null;
        $this->supplierName = (isset($data['supplier_name'])) ? $data['supplier_name'] : null;
        $this->productType = (isset($data['product_type'])) ? (int) $data['product_type'] : null;
        $this->typeName = (isset($data['type_name'])) ? $data['type_name'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->reference = (isset($data['reference'])) ? $data['reference'] : null;
        $this->price = (isset($data['price'])) ? (float) $data['price'] : null;
        $this->devise = (isset($data['devise'])) ? (int) $data['devise'] : null;
    }

    /************
     * ID
     ************/
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /************
     * SUPPLIER ID
     ************/
    /**
     * @param int $supplierId
     */
    public function setSupplierId($supplierId)
    {
        $this->supplierId = (int) $supplierId;
    }

    /**
     * @return int
     */
    public function getSupplierId()
    {
        return $this->supplierId;
    }

    /************
     * SUPPLIER NAME
     ************/
    /**
     * @param String $supplierName
     */
    public function setSupplierName($supplierName)
    {
        $this->supplierName = $supplierName;
    }

    /**
     * @return String
     */
    public function getSupplierName()
    {
        return stripcslashes($this->supplierName);
    }

    /************
     * PRODUCT TYPE
     ************/
    /**
     * @param int $productType
     */
    public function setProductType($productType)
    {
        $this->productType = (int) $productType;
    }

    /**
     * @return int
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /************
     * TYPE NAME
     ************/
    /**
     * @param String $typeName
     */
    public function setTypeName($typeName)
    {
        $this->typeName = $typeName;
    }

    /**
     * @return String
     */
    public function getTypeName()
    {
        return stripslashes($this->typeName);
    }

    /************
     * NAME
     ************/
    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return stripslashes($this->name);
    }

    /************
     * REFERENCE
     ************/
    /**
     * @param String $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return String
     */
    public function getReference()
    {
        return stripslashes($this->reference);
    }

    /************
     * PRICE
     ************/
    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = (float) $price;
    }

    public function getPrice($viewFormated = false)
    {
        return $viewFormated ? number_format($this->price, 2, ',', ' ') : number_format($this->price, 2, '.', '');

    }

    /************
     * DEVISE
     ************/
    /**
     * @param int $devise
     */
    public function setDevise($devise)
    {
        $this->devise = (int) $devise;
    }

    public function getDevise()
    {
        return $this->devise;

    }
}