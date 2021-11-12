<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'GestionUser\Controller\GestionUser' => 'GestionUser\Controller\GestionUserController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action][/:idUser]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'idUser'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'GestionUser\Controller\GestionUser',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),
);