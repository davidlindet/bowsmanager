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
    private $id; // int
    private $lastName; // String
    private $firstName; // String
    private $address; // String
    private $landline; //String
    private $mobile; // String
    private $email; // String
    private $website; // String
    private $collections; // collections array

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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Full Name (can change the order between last and first name)
     * @param bool $lastNameFirst
     * @return string
     */
    public function getName($lastNameFirst = true){
        $fullName = ($lastNameFirst) ? $this->lastName . " " . $this->firstName : $this->firstName . " " . $this->lastName;
        return stripslashes($fullName);
    }

    /*******************
     *  LAST NAME
     *******************/
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
        return stripslashes($this->lastName);
    }

    /*******************
     *  FIRST NAME
     *******************/
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
        return stripslashes($this->firstName);
    }

    /*******************
     *  ADDRESS
     *******************/
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
        return stripslashes($this->address);
    }

    /*******************
     *  LANDLINE
     *******************/
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

    /*******************
     *  MOBILE
     *******************/
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

    /*******************
     * EMAIL
     *******************/
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

    /*******************
     *  WEBSITE
     *******************/
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
        return stripslashes($this->website);
    }

    /*******************
     *  COLLECTIONS
     *******************/
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
    public function countCollections(){
        $count = 0;

        foreach($this->collections as $year => $collectionList) {
            $count += count($collectionList);
        }

        return $count;
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

    public function toArray(){
        return array(
            "id" => $this->id,
            "lastName" => $this->lastName,
            "firstName" => $this->firstName,
            "address" => $this->address,
            "landline" => $this->landline,
            "mobile" => $this->mobile,
            "email" => $this->email,
            "website" => $this->website,
            "nb_collections" => count($this->collections),
        );
    }
}