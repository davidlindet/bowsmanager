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
    private $owner; // int
    private $receptionTime; // timestamp
    private $sentStatus; // boolean
    private $paidStatus; // boolean

    public function __Construct($id = 0, $owner = null, $receptionTime = false, $sentStatus = false, $paidStatus = false){
        $this->id = $id;
        $this->owner = $owner;
        $this->receptionTime = ($receptionTime) ? $receptionTime : time();
        $this->sentStatus = $sentStatus;
        $this->paidStatus = $paidStatus;
    }

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : CollectionEnum::NEW_COLLECTION;
        $this->owner = (!empty($data['owner'])) ? $data['owner'] : null;
        $this->receptionTime =(!empty($data['reception_time'])) ? $data['reception_time'] : time();
        $this->sentStatus =(!empty($data['sent_status'])) ? $data['sent_status'] : false;
        $this->paidStatus = (!empty($data['paid_status'])) ? $data['paid_status'] : false;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return null
     */
    public function getOwner()
    {
        return $this->owner;
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