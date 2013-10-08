<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:30
 * To change this template use File | Settings | File Templates.
 */
namespace Client;

use Client\Model\Client;
use Client\Dao\ClientDao;
use Client\Service\ClientService;
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
                'ClientService' =>  function($sm) {
                    $dao = $sm->get('Client\Dao\ClientDao');
                    $service = new ClientService($dao);
                    return $service;
                },
                'Client\Dao\ClientDao' =>  function($sm) {
                    $tableGateway = $sm->get('ClientDaoGateway');
                    $table = new ClientDao($tableGateway);
                    return $table;
                },
                'ClientDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Client());
                    return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}