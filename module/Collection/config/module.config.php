<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Collection\Controller\Collection' => 'Collection\Controller\CollectionController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'collection' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/collection[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Collection\Controller\Collection',
                        'action'     => 'index',
                    ),
                ),
            ),
//            'client-save' => array(
//                'type'    => 'literal',
//                'options' => array(
//                    'route'    => '/client-save',
//                    'defaults' => array(
//                        'controller' => 'Client\Controller\Client',
//                        'action'     => 'save',
//                    ),
//                ),
//            ),
//            'client-delete' => array(
//                'type'    => 'literal',
//                'options' => array(
//                    'route'    => '/client-delete',
//                    'defaults' => array(
//                        'controller' => 'Client\Controller\Client',
//                        'action'     => 'delete',
//                    ),
//                ),
//            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
//            'formClient' => __DIR__ . '/../view/client/client/form.phtml',
            'bowList' => __DIR__ . '/../../Bow/view/bow/bow/index.phtml',
        ),
        'template_path_stack' => array(
            'collection' => __DIR__ . '/../view',
        ),
    ),
);