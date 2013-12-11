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
    private $productName;

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
        $this->productName = (isset($data['product_name'])) ? $data['product_name'] : null;
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
     * PRODUCT NAME
     ************/
    /**
     * @param String $productName
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return String
     */
    public function getProductName()
    {
        return stripslashes($this->productName);
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