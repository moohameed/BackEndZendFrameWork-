<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Logo\Controller\Logo' => 'Logo\Controller\LogoController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'logo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/logo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Logo\Controller\Logo',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'logo' => __DIR__ . '/../view',
        ),
    ),
);