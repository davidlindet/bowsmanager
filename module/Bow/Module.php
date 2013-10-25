<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace Bow;

use Bow\Model\Bow;
use Bow\Dao\BowDao;
use Bow\Service\BowService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'BowService' =>  function($sm) {
                    $dao = $sm->get('Bow\Dao\BowDao');
                    $service = new BowService($dao);
                    return $service;
                },
                'Bow\Dao\BowDao' =>  function($sm) {
                    $tableGateway = $sm->get('BowDaoGateway');
                    $table = new BowDao($tableGateway);
                    return $table;
                },
                'BowDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Bow());
                    return new TableGateway('bm_bow', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}