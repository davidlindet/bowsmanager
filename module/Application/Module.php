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

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $viewHelperManager = $e->getApplication()->getServiceManager()->get('viewhelpermanager');
        $viewHelperManager->setFactory('sectionName', function($sm) use ($e) {
            $viewHelper = new View\Helper\SectionName($e->getRouteMatch());
            return $viewHelper;
        });

        $viewHelperManager->setFactory('fileType', function($sm) use ($e) {
            $viewHelper = new View\Helper\FileType();
            return $viewHelper;
        });

        $viewHelperManager->setFactory('devise', function($sm) use ($e) {
            $viewHelper = new View\Helper\Devise();
            return $viewHelper;
        });

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
}
