<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Service;

use Supplier\Enum\SupplierEnum;
use Supplier\Model\Supplier;
use Supplier\Dao\SupplierDao;
use Supplier\Enum\SupplierlEnum;

class SupplierService
{
    /**
     * @var $supplierDao SupplierDao
     */
    protected $supplierDao;


    public function __construct($supplierDao){
        $this->supplierDao = $supplierDao;
    }

    public function getAll(){
        return $this->supplierDao->fetchAll();
    }

    public function getById($supplierId){
        $supplierId = (int) $supplierId;
        return ($supplierId == SupplierEnum::NEW_SUPPLIER) ? new Supplier() : $this->supplierDao->getSupplier($supplierId);
    }

    public function save($supplierModel){
        try {
            $supplierId = $this->supplierDao->saveSupplier($supplierModel);
            $result = array('success'=> true, 'id' => (int) $supplierId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($supplierId){
        try {
            //delete supplier of the database
            $this->supplierDao->deleteSupplier($supplierId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

//    public function search($query) {
//        return $this->billDao->fetchAllByQuery($query);
//    }

}