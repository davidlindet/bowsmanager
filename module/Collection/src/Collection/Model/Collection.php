<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Model;

use Collection\Enum\CollectionEnum;
use Bow\Model\Bow;

class Collection
{
    private $id;
    private $ownerId; // int
    private $ownerName; // String
    private $receptionTime; // timestamp
    private $returnTime; // timestamp
    private $packageNumber; // String
    private $billReference; // String
    private $billAmount; // Float
    private $paidStatus; // boolean
    private $bows;
    private $attachments;

    public function __Construct($id = 0,
                                $ownerId = null,
                                $ownerName = "",
                                $receptionTime = false,
                                $returnTime = CollectionEnum::NO_RETURN_TIME,
                                $packageNumber = false,
                                $billReference = false,
                                $billAmount = false,
                                $paidStatus = false){
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->ownerName = $ownerName;
        $this->receptionTime = ($receptionTime) ? $receptionTime : time();
        $this->returnTime = $returnTime;
        $this->packageNumber = $packageNumber;
        $this->billReference = $billReference;
        $this->billAmount = $billAmount;
        $this->paidStatus = $paidStatus;
        $this->bows = array();
        $this->attachments = array();
    }

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? $data['id'] : CollectionEnum::NEW_COLLECTION;
        $this->ownerId = (isset($data['owner'])) ? $data['owner'] : null;
        $name = "";
        if(!empty($data['first_name'])){
            $name .= $data['first_name'] . " ";
        }
        if(!empty($data['last_name'])){
            $name .= $data['last_name'];
        }
        $this->ownerName = $name;
        $this->receptionTime =(!empty($data['reception_time'])) ? $data['reception_time'] : false;
        $this->returnTime =(!empty($data['return_time'])) ? $data['return_time'] : CollectionEnum::NO_RETURN_TIME;
        $this->packageNumber =(!empty($data['package_number'])) ? $data['package_number'] : null;
        $this->billReference =(!empty($data['bill_reference'])) ? $data['bill_reference'] : null;
        $this->billAmount =(isset($data['bill_amount'])) ? (float) $data['bill_amount'] : null;
        $this->paidStatus = (isset($data['paid_status'])) ? $data['paid_status'] : false;

        $attachements = array();
        if(!empty($data['attachments'])) {
            foreach(explode("--", $data['attachments']) as $attachement){
                $attachements[$attachement] = $attachement;
            }
        }
        $this->attachments =  $attachements;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /*******************
     *  OWNER ID
     *******************/
    /**
     * @param int $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = (int) $ownerId;
    }

    /**
     * @return int
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /*******************
     *  OWNER NAME
     *******************/
    /**
     * @param string $ownerName
     */
    public function setOwnerName($ownerName)
    {
        $this->ownerName = $ownerName;
    }

    /**
     * @return string
     */
    public function getOwnerName()
    {
        return stripslashes($this->ownerName);
    }

    /*******************
     *  RECEPTION TIME
     *******************/
    /**
     * @param timestamp $receptionTime
     */
    public function setReceptionTime($receptionTime)
    {
        $this->receptionTime = $receptionTime;
    }

    /**
     * @return timestamp
     */
    public function getReceptionTime($formated = true)
    {
        $receptionTime = $this->receptionTime;
        if($formated){
            $receptionTime = date('d-m-Y', $receptionTime);
        }
        return $receptionTime;
    }

    /*******************
     *  RETURN TIME
     *******************/
    /**
     * @param timestamp $returnTime
     */
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime ? $returnTime : CollectionEnum::NO_RETURN_TIME;
    }

    /**
     * @return timestamp
     */
    public function getReturnTime($formated = true)
    {
        $returnTime = $this->returnTime;
        if($formated){
            $returnTime = ($returnTime == CollectionEnum::NO_RETURN_TIME) ? "" : date('d-m-Y', $returnTime);
        }
        return $returnTime;
    }

    /*******************
     *  SENT STATUS
     *******************/
    /**
     * @return boolean
     */
    public function isSent()
    {
        return ($this->returnTime == CollectionEnum::NO_RETURN_TIME) ? false : true;
    }

    /*******************
     *  PACKAGE NUMBER
     *******************/
    /**
     * @param string $packageNumber
     */
    public function setPackageNumber($packageNumber)
    {
        $this->packageNumber = $packageNumber;
    }

    /**
     * @return string
     */
    public function getPackageNumber()
    {
        return stripslashes($this->packageNumber);
    }

    /*******************
     *  BILL REFERENCE
     *******************/
    /**
     * @param string $billReference
     */
    public function setBillReference($billReference)
    {
        $this->billReference = $billReference;
    }

    /**
     * @return string
     */
    public function getBillReference()
    {
        return stripslashes($this->billReference);
    }

    /*******************
     *  BILL AMOUNT
     *******************/
    /**
     * @param float $billAmount
     */
    public function setBillAmount($billAmount)
    {
        $this->billAmount = (float) $billAmount;
    }

    /**
     * @return float
     */
    public function getBillAmount()
    {
        return (float) $this->billAmount;
    }

    /*******************
     *  PAID STATUS
     *******************/
    /**
     * @param boolean $paidStatus
     */
    public function setPaidStatus($paidStatus)
    {
        $this->paidStatus = $paidStatus;
    }

    /**
     * @return boolean
     */
    public function isPaid()
    {
        return $this->paidStatus;
    }

    /*******************
     *  BOWS
     *******************/
    /**
     * @param array $bows
     */
    public function setBows($bows)
    {
        $this->bows = $bows;
    }

    /**
     * @return array
     */
    public function getBows()
    {
        return $this->bows;
    }

    /**
     * @return int
     */
    public function countBows(){
        return count($this->bows);
    }

    /**
     * @param Bow $bow
     */
    public function addBow(Bow $bow){
        $this->bows[$bow->getId()] = $bow;
    }

    public function removeBow(int $bowId){
        unset($this->bows[$bowId]);
    }

    /*******************
     *  ATTACHEMENTS
     *******************/
    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    public function addAttachment($attachment)
    {
        $this->attachments[$attachment] = $attachment;
    }

    public function removeAttachment($attachment)
    {
        unset($this->attachments[$attachment]);
        unlink(__DIR__ . "/../../../../../public/img/attachment/" . $attachment);
    }

    public function hasAttachments()
    {
        return empty($this->attachments) ? false : true;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

}