<?php

namespace GestionGouvernorat;
use GestionGouvernorat\Model\GestionGouvernoratTable;
use Zend\Mail\Transport\SmtpOptions;


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
            'GestionGouvernorat\Model\GestionGouvernoratTable' => function($sm) {
                $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                $table = new GestionGouvernoratTable($dbAdapter);
                return $table;
            },
        ),
        );
            	  // Add this for SMTP

           //'GestionUser\Model\GestionUserTable' => function (ServiceManager $serviceManager){
           //$config = $serviceManager->get('Config');      
	  //$transport = new Smtp(); 
	  //$transport->setOptions(new SmtpOptions($config['mail']['transport']['options']));
	  //return $transport;                                     

          
    
    } 
}