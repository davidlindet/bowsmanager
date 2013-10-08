<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Application\Model\Bow;
use Application\Service\BowService;
use Application\Dao\BowDao;

use Application\Model\Client;
use Application\Service\ClientService;
use Application\Dao\ClientDao;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->setLocale('fr_FR');
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                /**
                 * BOW
                 */
                'BowService' =>  function($sm) {
                    $dao = $sm->get('BowDao');
                    $service = new BowService($dao);
                    return $service;
                },
                'BowDao' =>  function($sm) {
                    $tableGateway = $sm->get('BowDaoGateway');
                    $table = new BowDao($tableGateway);
                    return $table;
                },
                'BowDaoGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Bow());
                    return new TableGateway('bow', $dbAdapter, null, $resultSetPrototype);
                },
                /**
                 * CLIENT
                 */
                'ClientService' =>  function($sm) {
                    $dao = $sm->get('ClientDao');
                    $service = new ClientService($dao);
                    return $service;
                },
                'ClientDao' =>  function($sm) {
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
