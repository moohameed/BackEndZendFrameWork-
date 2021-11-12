<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Lists\Controller\Lists' => 'Lists\Controller\ListsController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'lists' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/lists[/:action][/:id][/:type]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',                      
                        'type'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Lists\Controller\Lists',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'lists' => __DIR__ . '/../view',
        ),
    ),
);