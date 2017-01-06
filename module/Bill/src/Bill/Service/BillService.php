<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bill\Service;

use Bill\Model\Bill;
use Bill\Dao\BillDao;
use Bill\Enum\BillEnum;
use Upload\Service\UploadService;

class BillService
{
    /**
     * @var $billDao BillDao
     */
    protected $billDao;

    /**
     * @var $uploadService UploadService
     */
    protected $uploadService;

    public function __construct($billDao, $uploadService){
        $this->billDao = $billDao;
        $this->uploadService = $uploadService;
    }

    public function getAll(){
        $bills = $this->billDao->fetchAll();

        $groupBills = array();
        foreach($bills as $bill) {
            $year = $bill->getBillingYear();
            $groupBills[$year][] = $bill;
        }

        return $groupBills;
    }

    public function getAllByCollection($collectionId){
        return $this->billDao->fetchAllByCollection($collectionId);
    }

    public function getById($billId){
        $billId = (int) $billId;
        return ($billId == BillEnum::NEW_BILL) ? new Bill() : $this->billDao->getBill($billId);
    }

    public function save($billModel){
        try {
            $billId = $this->billDao->saveBill($billModel);
            $result = array('success'=> true, 'id' => (int) $billId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($billId){
        try {
            //delete all attachments related to this bill
            $billModel = $this->getById($billId);
            foreach($billModel->getAttachments() as $attachment) {
                $billModel->removeAttachment($attachment, $this->uploadService);
            }
            //delete bill in the database
            $this->billDao->deleteBill($billId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function getBillsNotPaid(){
        return $this->billDao->getBillsNotPaid();
    }

//    public function search($query) {
//        return $this->billDao->fetchAllByQuery($query);
//    }

}