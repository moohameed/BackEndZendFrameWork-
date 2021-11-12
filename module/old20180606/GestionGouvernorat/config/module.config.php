<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'GestionGouvernorat\Controller\GestionGouvernorat' => 'GestionGouvernorat\Controller\GestionGouvernoratController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'gouvernorat' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/gouvernorat[/:action][/:idGouvernorat]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'idUser'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'GestionGouvernorat\Controller\GestionGouvernorat',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'gouvernorat' => __DIR__ . '/../view',
        ),
    ),
);