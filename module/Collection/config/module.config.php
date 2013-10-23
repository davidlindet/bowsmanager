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
                    'route'    => '/collection[/][:action][/:id][/:clientId][/:section]',
                    'constraints' => array(
                        'action'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'       => '[0-9]+',
                        'clientId' => '[0-9]+',
                        'section'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Collection\Controller\Collection',
                        'action'     => 'index',
                    ),
                ),
            ),
            'collection-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/collection-save',
                    'defaults' => array(
                        'controller' => 'Collection\Controller\Collection',
                        'action'     => 'save',
                    ),
                ),
            ),
            'collection-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/collection-delete',
                    'defaults' => array(
                        'controller' => 'Collection\Controller\Collection',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'formCollection' => __DIR__ . '/../view/collection/collection/form.phtml',
            'bowList' => __DIR__ . '/../../Bow/view/bow/bow/index.phtml',
        ),
        'template_path_stack' => array(
            'collection' => __DIR__ . '/../view',
        ),
    ),
);