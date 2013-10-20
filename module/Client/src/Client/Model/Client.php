<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Model;

use Client\Enum\ClientEnum;
use Client\Enum\ClientUpdateActionEnum;
use Collection\Model\Collection;

class Client
{
    private $id;
    private $lastName;
    private $firstName;
    private $address;
    private $landline;
    private $mobile;
    private $email;
    private $website;
    private $collections;

    public function __Construct($id = 0, $lastName = "", $firstName = "", $address = "", $landline = "", $mobile = "", $email = "", $website = "", $collections = array()){
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->address = $address;
        $this->landline = $landline;
        $this->mobile = $mobile;
        $this->email = $email;
        $this->website = $website;
        $this->collections = $collections;
    }

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : ClientEnum::NEW_CLIENT;
        $this->lastName = (!empty($data['last_name'])) ? $data['last_name'] : "";
        $this->firstName =(!empty($data['first_name'])) ? $data['first_name'] : "";
        $this->address =(!empty($data['address'])) ? $data['address'] : "";
        $this->landline = (!empty($data['landline'])) ? $data['landline'] : "";
        $this->mobile = (!empty($data['mobile'])) ? $data['mobile'] : "";
        $this->email = (!empty($data['email'])) ? $data['email'] : "";
        $this->website = (!empty($data['website'])) ? $data['website'] : "";
    }

    public function getName($lastNameFirst = true){
        return ($lastNameFirst) ? $this->lastName . " " . $this->firstName : $this->firstName . " " . $this->lastName;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $landline
     */
    public function setLandline($landline)
    {
        $this->landline = $landline;
    }

    /**
     * @return mixed
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param array $collections
     */
    public function setCollections($collections)
    {
        $this->collections = $collections;
    }

    /**
     * @return array
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * @return int
     */
    public function getCollectionsCount(){
        return count($this->collections);
    }

    /**
     * @param Collection $collection
     */
    public function addCollection(Collection $collection){
        $this->collections[] = $collection;
    }

    public function removeCollection(int $collectionId){
        unset($this->collections[$collectionId]);
    }
}