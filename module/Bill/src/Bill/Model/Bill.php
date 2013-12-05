<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Bill\Model;

use Bill\Enum\BillEnum;
use Upload\Service\UploadService;

class Bill
{
    private $id;

    /**
     * @var int id of the collection related to
     */
    private $collectionId;

    /**
     * @var float amount of the bill
     */
    private $amount;

    /**
     * @var String reference of the bill
     */
    private $reference;

    /**
     * Pictures of the bill
     */
    private $attachments;

    public function __Constructor($reference, $amount, $collectionId){
        $this->id = BillEnum::NEW_BILL;
        $this->collectionId = $collectionId;
        $this->amount = (float) $amount;
        $this->reference = $reference;
        $this->attachments = array();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
        $this->collectionId = (isset($data['collection_id'])) ? (int) $data['collection_id'] : null;
        $this->amount = (isset($data['amount'])) ? (float) $data['amount'] : null;
        $this->reference = (isset($data['reference'])) ? $data['reference'] : null;

        $attachements = array();
        if(!empty($data['attachments'])) {
            foreach(explode("--", $data['attachments']) as $attachement){
                $attachements[$attachement] = $attachement;
            }
        }
        $this->attachments =  $attachements;
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
     * COLLECTION ID
     ************/
    /**
     * @param int $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return int
     */
    public function getCollectionId()
    {
        return (int) $this->collectionId;
    }

    /************
     * AMOUNT
     ************/
    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }


    /************
     * REFERENCE
     ************/
    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /************
     * ATTACHMENTS
     ************/
    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param $attachment add 1 file
     */
    public function addAttachment($attachment)
    {
        $this->attachments[$attachment] = $attachment;
    }

    /**
     * @param $attachment remove 1 file (from the server as well)
     */
    public function removeAttachment($fileName, UploadService $uploadService)
    {
        unset($this->attachments[$fileName]);
        $uploadService->deleteFile($fileName);
    }

    /**
     * @return bool contain files
     */
    public function hasAttachments()
    {
        return empty($this->attachments) ? false : true;
    }


}