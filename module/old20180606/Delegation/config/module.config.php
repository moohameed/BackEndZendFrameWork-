<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Delegation\Controller\Delegation' => 'Delegation\Controller\DelegationController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'delegation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/delegation[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Delegation\Controller\Delegation',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'delegation' => __DIR__ . '/../view',
        ),
    ),
);