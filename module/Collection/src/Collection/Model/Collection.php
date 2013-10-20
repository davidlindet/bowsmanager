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

class Collection
{
    private $id;
    private $ownerId; // int
    private $ownerName; // String
    private $receptionTime; // timestamp
    private $sentStatus; // boolean
    private $paidStatus; // boolean

    public function __Construct($id = 0, $ownerId = null, $ownerName = "", $receptionTime = false, $sentStatus = false, $paidStatus = false){
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->ownerName = $ownerName;
        $this->receptionTime = ($receptionTime) ? $receptionTime : time();
        $this->sentStatus = $sentStatus;
        $this->paidStatus = $paidStatus;
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
        $this->receptionTime =(!empty($data['reception_time'])) ? $data['reception_time'] : time();
        $this->sentStatus =(isset($data['sent_status'])) ? $data['sent_status'] : false;
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
        $this->ownerId = $ownerId;
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
    public function getPaidStatus()
    {
        return $this->paidStatus;
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
        return date('d/m/Y', $this->receptionTime);
    }

    /**
     * @param boolean $sentStatus
     */
    public function setSentStatus($sentStatus)
    {
        $this->sentStatus = $sentStatus;
    }

    /**
     * @return boolean
     */
    public function getSentStatus()
    {
        return $this->sentStatus;
    }
}