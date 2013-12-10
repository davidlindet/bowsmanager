<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Model;

class ProductType
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var String
     */
    private $name;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
        $this->name = (isset($data['name'])) ? $data['name'] : null;
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

}