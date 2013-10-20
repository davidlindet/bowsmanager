<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace Collection;

use Collection\Model\Collection;
use Collection\Dao\CollectionDao;
use Collection\Service\CollectionService;
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
                'CollectionService' =>  function($sm) {
                    $dao = $sm->get('Collection\Dao\CollectionDao');
                    $service = new CollectionService($dao);
                    return $service;
                },
                'Collection\Dao\CollectionDao' =>  function($sm) {
                    $tableGateway = $sm->get('CollectionDaoGateway');
                    $table = new CollectionDao($tableGateway);
                    return $table;
                },
                'CollectionDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Collection());
                    return new TableGateway('collection', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}