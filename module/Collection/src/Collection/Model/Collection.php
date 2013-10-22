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

    public function __Construct($id = 0,
                                $ownerId = null,
                                $ownerName = "",
                                $receptionTime = false,
                                $returnTime = false,
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
        $this->returnTime =(!empty($data['return_time'])) ? $data['return_time'] : false;
        $this->packageNumber =(!empty($data['package_number'])) ? $data['package_number'] : null;
        $this->billReference =(!empty($data['bill_reference'])) ? $data['bill_reference'] : null;
        $this->billAmount =(isset($data['bill_amount'])) ? $data['bill_amount'] : null;
        $this->paidStatus = (isset($data['paid_status'])) ? $data['paid_status'] : false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $ownerId
     */
    public function setOwnerId($ownerId)
    {
        $this->ownerId = (int) $ownerId;
    }

    /**
     * @return null
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * @param mixed $ownerName
     */
    public function setOwnerName($ownerName)
    {
        $this->ownerName = $ownerName;
    }

    /**
     * @return mixed
     */
    public function getOwnerName()
    {
        return $this->ownerName;
    }

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

    /**
     * @return boolean
     */
    public function isSent()
    {
        return $this->returnTime ? true : false;
    }

    /**
     * @param bool|int $receptionTime
     */
    public function setReceptionTime($receptionTime)
    {
        $this->receptionTime = $receptionTime;
    }

    /**
     * @return bool|int
     */
    public function getReceptionTime()
    {
        return date('d-m-Y', $this->receptionTime);
    }

    /**
     * @param boolean $billAmount
     */
    public function setBillAmount($billAmount)
    {
        $this->billAmount = $billAmount;
    }

    /**
     * @return boolean
     */
    public function getBillAmount()
    {
        return $this->billAmount;
    }

    /**
     * @param boolean $billReference
     */
    public function setBillReference($billReference)
    {
        $this->billReference = $billReference;
    }

    /**
     * @return boolean
     */
    public function getBillReference()
    {
        return $this->billReference;
    }

    /**
     * @param boolean $packageNumber
     */
    public function setPackageNumber($packageNumber)
    {
        $this->packageNumber = $packageNumber;
    }

    /**
     * @return boolean
     */
    public function getPackageNumber()
    {
        return $this->packageNumber;
    }

    /**
     * @param boolean $returnTime
     */
    public function setReturnTime($returnTime)
    {
        $this->returnTime = $returnTime;
    }

    /**
     * @return boolean
     */
    public function getReturnTime()
    {
        return date('d-m-Y', $this->returnTime);
    }

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
}