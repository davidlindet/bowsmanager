<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Model;

class Supplier
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var String
     */
    private $name;

    /**
     * @var String
     */
    private $address;

    /**
     * @var String
     */
    private $phone;

    /**
     * @var String
     */
    private $email;

    /**
     * @var String
     */
    private $website;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->phone = (isset($data['phone'])) ? $data['phone'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->website = (isset($data['website'])) ? $data['website'] : null;
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
     * Name
     ************/
    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return stripslashes($this->name);
    }

    /*******************
     *  ADDRESS
     *******************/
    /**
     * @param String $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return String
     */
    public function getAddress()
    {
        return stripslashes($this->address);
    }

    /*******************
     * PHONE
     *******************/
    /**
     * @param String $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return String
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /*******************
     * EMAIL
     *******************/
    /**
     * @param String $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return String
     */
    public function getEmail()
    {
        return $this->email;
    }

    /*******************
     * WEBSITE
     *******************/
    /**
     * @param String $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return String
     */
    public function getWebsite()
    {
        return stripslashes($this->website);
    }

}