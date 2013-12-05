<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace Bill;

use Bill\Model\Bill;
use Bill\Dao\BillDao;
use Bill\Service\BillService;
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
                'BillService' =>  function($sm) {
                    $dao = $sm->get('Bill\Dao\BillDao');
                    $service = new BillService($dao);
                    return $service;
                },
                'Bill\Dao\BillDao' =>  function($sm) {
                    $tableGateway = $sm->get('BillDaoGateway');
                    $table = new BillDao($tableGateway);
                    return $table;
                },
                'BillDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Bill());
                    return new TableGateway('bm_bill', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}