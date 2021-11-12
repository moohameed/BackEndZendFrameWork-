<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceManager;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        //echo '1';exit;
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    public function getServiceConfig() {
        return array(
            'factories' => array(
                'db-adapter' => function($sm) {
            $config = $sm->get('config');
            $config = $config['db'];
            $dbAdapter = new DbAdapter($config);
            return $dbAdapter;
        },
                // Add this for SMTP transport
                'mail.transport' => function (ServiceManager $serviceManager) {
            $config = $serviceManager->get('Config');
            $transport = new Smtp();
            $transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
            return $transport;
        },
            ),
        );
    }
}
