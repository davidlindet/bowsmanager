<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Supplier\Model\Supplier;
use Supplier\Dao\SupplierDao;
use Supplier\Service\SupplierService;

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
                'SupplierService' =>  function($sm) {
                    $dao = $sm->get('Supplier\Dao\SupplierDao');
                    $service = new SupplierService($dao);
                    return $service;
                },
                'Supplier\Dao\SupplierDao' =>  function($sm) {
                    $tableGateway = $sm->get('SupplierDaoGateway');
                    $table = new SupplierDao($tableGateway);
                    return $table;
                },
                'SupplierDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Supplier());
                    return new TableGateway('bm_supplier', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}