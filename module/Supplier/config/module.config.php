<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Supplier\Controller\Supplier' => 'Supplier\Controller\SupplierController',
        ),
    ),
    'router' => array(
        'routes' => array(
            /**
             *  SUPPLIER ROUTES
             */
            'supplier' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier[/][:action][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Supplier',
                        'action'     => 'index',
                    ),
                ),
            ),
            'supplier-list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/supplier-list[/][:section][/]',
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
                    'route'    => '/supplier-details[/][:id][/][:section]',
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
            /**
             *  PRODUCT ROUTES
             */
            'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/][:action][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-list[/][:section][/]',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-add[/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'add',
                    ),
                ),
            ),
            'product-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'product-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-details[/][:id][/][:section]',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'details',
                    ),
                ),
            ),
            'product-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-save',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
                        'action'     => 'save',
                    ),
                ),
            ),
            'product-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-delete',
                    'defaults' => array(
                        'controller' => 'Product\Controller\Product',
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