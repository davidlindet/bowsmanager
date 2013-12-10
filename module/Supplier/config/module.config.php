<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Supplier\Controller\Supplier' => 'Supplier\Controller\SupplierController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'supplier' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier[/][:action][/:id][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'            => '[0-9]+',
                        'collectionId'  => '[0-9]+',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'index',
                    ),
                ),
            ),
            'supplier-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier-add[/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'add',
                    ),
                ),
            ),
            'supplier-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'supplier-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier-details[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'details',
                    ),
                ),
            ),
            'supplier-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/supplier-save',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'save',
                    ),
                ),
            ),
            'supplier-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/supplier-delete',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/empty' => __DIR__ . '/../../Application/view/layout/empty.phtml',
            'formSupplier' => __DIR__ . '/../view/supplier/supplier/form.phtml',
        ),
        'template_path_stack' => array(
            'supplier' => __DIR__ . '/../view',
        ),
    ),
);