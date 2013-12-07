<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Model;

use Bill\Model\Bill;
use Collection\Enum\CollectionEnum;
use Bow\Model\Bow;

class Collection
{
    private $id;
    /**
     * @var int
     */
    private $ownerId;
    /**
     * @var string
     */
    private $ownerName;
    /**
     * @var int (timestamp)
     */
    private $receptionTime;
    /**
     * @var int (timestamp)
     */
    private $returnTime;
    /**
     * @var string
     */
    private $packageNumber;
    /**
     * @var array
     */
    private $bills;
    /**
     * @var array
     */
    private $bows;

    public function __Construct($id = 0,
                                $ownerId = null,
                                $ownerName = "",
                                $receptionTime = false,
                                $returnTime = CollectionEnum::NO_RETURN_TIME,
                                $packageNumber = false){
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->ownerName = $ownerName;
        $this->receptionTime = ($receptionTime) ? $receptionTime : time();
        $this->returnTime = $returnTime;
        $this->packageNumber = $packageNumber;
        $this->bills = array();
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
        $this->returnTime =(!empty($data['return_time'])) ? $data['return_time'] : CollectionEnum::NO_RETURN_TIME;
        $this->packageNumber =(!empty($data['package_number'])) ? $data['package_number'] : null;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string collections name
     */
    public function getName(){
        return $this->ownerName . " -- " . $this->getReceptionTime();
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
     *  BILL
     *******************/
    /**
     * @param int $billId
     */
    public function setBills($bills)
    {
        $this->bills = $bills;
    }

    /**
     * @return string
     */
    public function getBills()
    {
        return $this->bills;
    }

    /**
     * @return int
     */
    public function countBills(){
        return count($this->bills);
    }

    /**
     * @param Bill $bill
     */
    public function addBill(Bill $bill){
        $this->bills[$bill->getId()] = $bill;
    }

    public function removeBill(int $billId){
        unset($this->bills[$billId]);
    }

    /**
     * @return bool return true if all bills paid
     */
    public function isPaid(){
        $isPaid = count($this->bills) > 0 ? true : false;

        /** @var $bill Bill */
        foreach($this->bills as $bill){
            if(!$bill->isPaid()){
                $isPaid = false;
                break;
            }
        }
        return $isPaid;
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

}