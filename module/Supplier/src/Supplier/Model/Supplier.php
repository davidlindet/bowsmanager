<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Model;

use Supplier\Enum\SupplierEnum;

class Supplier
{
    private $id;

//    /**
//     * @var int id of the collection related to
//     */
//    private $collectionId;
//
//    /**
//     * @var string collection name
//     */
//    private $collectionName = "";
//
//    /**
//     * @var float amount of the bill
//     */
//    private $amount;
//
//    /**
//     * @var String reference of the bill
//     */
//    private $reference;
//
//    /**
//     * @var boolean is bill paid
//     */
//    private $isPaid;
//
//    /**
//     * Pictures of the bill
//     */
//    private $attachments = array();
//
//    public function __Constructor($reference, $amount, $collectionId){
//        $this->id = BillEnum::NEW_BILL;
//        $this->collectionId = $collectionId;
//        $this->amount = (float) $amount;
//        $this->reference = $reference;
//        $this->isPaid = false;
//    }
//
//    public function exchangeArray($data)
//    {
//        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
//        $this->collectionId = (isset($data['collection_id'])) ? (int) $data['collection_id'] : null;
//        $this->amount = (isset($data['amount'])) ? (float) $data['amount'] : null;
//        $this->reference = (isset($data['reference'])) ? $data['reference'] : null;
//        $this->isPaid = (isset($data['is_paid'])) ? (boolean) $data['is_paid'] : null;
//
//        $attachements = array();
//        if(!empty($data['attachments'])) {
//            foreach(explode("--", $data['attachments']) as $attachement){
//                $attachements[] = $attachement;
//            }
//        }
//        $this->attachments =  $attachements;
//    }
//
//    /************
//     * ID
//     ************/
//    /**
//     * @return mixed
//     */
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    /************
//     * COLLECTION ID
//     ************/
//    /**
//     * @param int $collectionId
//     */
//    public function setCollectionId($collectionId)
//    {
//        $this->collectionId = $collectionId;
//    }
//
//    /**
//     * @return int
//     */
//    public function getCollectionId()
//    {
//        return (int) $this->collectionId;
//    }
//
//    /**
//     * @return boolean
//     */
//    public function isConnectedToCollection()
//    {
//        return $this->collectionId == BillEnum::NO_COLLECTION ? false : true;
//    }
//
//    /************
//     * COLLECTION NAME
//     ************/
//    /**
//     * @param string $collectionName
//     */
//    public function setCollectionName($collectionName)
//    {
//        $this->collectionName = $collectionName;
//    }
//
//    /**
//     * @return string
//     */
//    public function getCollectionName()
//    {
//        return $this->collectionName;
//    }
//
//    /************
//     * AMOUNT
//     ************/
//    /**
//     * @param float $amount
//     */
//    public function setAmount($amount)
//    {
//        $this->amount = $amount;
//    }
//
//    /**
//     * @return float
//     */
//    public function getAmount($viewFormated = false)
//    {
//        return $viewFormated ? number_format($this->amount, 2, ',', ' ') : number_format($this->amount, 2, '.', '');
//    }
//
//    /************
//     * REFERENCE
//     ************/
//    /**
//     * @param string $reference
//     */
//    public function setReference($reference)
//    {
//        $this->reference = $reference;
//    }
//
//    /**
//     * @return string
//     */
//    public function getReference()
//    {
//        return $this->reference;
//    }
//
//    /************
//     * IS PAID
//     ************/
//    /**
//     * @param boolean $isPaid
//     */
//    public function setIsPaid($isPaid)
//    {
//        $this->isPaid = $isPaid;
//    }
//
//    /**
//     * @return boolean
//     */
//    public function isPaid()
//    {
//        return $this->isPaid;
//    }
//
//
//    /************
//     * ATTACHMENTS
//     ************/
//    /**
//     * @param mixed $attachments
//     */
//    public function setAttachments($attachments)
//    {
//        $this->attachments = $attachments;
//    }
//
//    /**
//     * @return mixed
//     */
//    public function getAttachments()
//    {
//        return $this->attachments;
//    }
//
//    public function getLatestAvailableKeyAttachment()
//    {
//        $size = count($this->attachments);
//        $key = 0;
//        if($size > 0){
//            $fileData = $this->attachments[$size-1];
//            $dataArray = explode(UploadEnum::SEPARATOR, $fileData);
//            $key = $dataArray[2] + 1;
//        }
//        return $key;
//    }
//
//    /**
//     * @param $attachment add 1 file
//     */
//    public function addAttachment($attachment)
//    {
//        $this->attachments[$attachment] = $attachment;
//    }
//
//    /**
//     * @param $attachment remove 1 file (from the server as well)
//     */
//    public function removeAttachment($fileName, UploadService $uploadService)
//    {
//        $key = array_search($fileName, $this->attachments);
//        unset($this->attachments[$key]);
//        $uploadService->deleteFile($fileName);
//    }
//
//    /**
//     * @return bool contain files
//     */
//    public function hasAttachments()
//    {
//        return empty($this->attachments) ? false : true;
//    }

}