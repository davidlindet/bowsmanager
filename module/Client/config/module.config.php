<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Client\Controller\Client' => 'Client\Controller\ClientController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'client' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/client[/][:action][/][:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'index',
                    ),
                ),
            ),
            'client-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/client-details[/][:id]',
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'details',
                    ),
                ),
            ),
            'client-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/client-add[/][:id]',
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'add',
                    ),
                ),
            ),
            'client-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/client-edit[/][:id]',
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'client-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/client-save',
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'save',
                    ),
                ),
            ),
            'client-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/client-delete',
                    'defaults' => array(
                        'controller' => 'Client\Controller\Client',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'formClient' => __DIR__ . '/../view/client/client/form.phtml',
            'collectionList' => __DIR__ . '/../../Collection/view/collection/collection/index.phtml',
        ),
        'template_path_stack' => array(
            'client' => __DIR__ . '/../view',
        ),
    ),
);