<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Service;

use Supplier\Model\ProductType;
use Supplier\Dao\ProductTypeDao;
use Supplier\Enum\ProductTypeEnum;

class ProductTypeService
{
    /**
     * @var $productTypeDao ProductTypeDao
     */
    protected $productTypeDao;


    public function __construct($productTypeDao){
        $this->productTypeDao = $productTypeDao;
    }

    public function getAll(){
        return $this->productTypeDao->fetchAll();
    }

    public function getById($productTypeId){
        $productTypeId = (int) $productTypeId;
        return ($productTypeId == ProductTypeEnum::NEW_PRODUCT_TYPE) ? new ProductType() : $this->productTypeDao->getProductType($productTypeId);
    }

    public function save($productTypeModel){
        try {
            $productTypeId = $this->productTypeDao->saveProductType($productTypeModel);
            $result = array('success'=> true, 'id' => (int) $productTypeId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($productTypeId){
        try {
            //delete productType of the database
            $this->productTypeDao->deleteProductType($productTypeId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

}