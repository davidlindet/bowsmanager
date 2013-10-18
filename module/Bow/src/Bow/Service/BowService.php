<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bow\Service;

use Bow\Model\Bow;
use Bow\Dao\BowDao;
use Bow\Enum\BowEnum;

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

    public function getById($bowId){
        $bowId = (int) $bowId;
        return ($bowId == BowEnum::NEW_BOW) ? new Bow() : $this->bowDao->getBow($bowId);
    }
}