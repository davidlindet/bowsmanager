<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Service;

use Application\Dao\BowDao;

class BowService
{
    /**
     * @var $bowDao BowDao
     */
    protected $bowDao;

    public function __construct($bowDao){
        $this->bowDao = $bowDao;
    }

    public function getAll(){
        return $this->bowDao->fetchAll();
    }
}