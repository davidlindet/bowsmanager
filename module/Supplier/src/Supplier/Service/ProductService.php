<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Service;

use Supplier\Model\Product;
use Supplier\Dao\ProductDao;
use Supplier\Enum\ProductEnum;

class ProductService
{
    /**
     * @var $productDao ProductDao
     */
    protected $productDao;


    public function __construct($productDao){
        $this->productDao = $productDao;
    }

    public function getAll(){
        return $this->productDao->fetchAll();
    }

    public function getAllByProductType($type){
        return $this->productDao->fetchAllByProductType($type);
    }

    public function getById($productId){
        $productId = (int) $productId;
        return ($productId == ProductEnum::NEW_PRODUCT) ? new Product() : $this->productDao->getProduct($productId);
    }

    public function save($productModel){
        try {
            $productId = $this->productDao->saveProduct($productModel);
            $result = array('success'=> true, 'id' => (int) $productId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($productId){
        try {
            //delete product of the database
            $this->productDao->deleteProduct($productId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

}