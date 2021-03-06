<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Supplier\Controller\Supplier' => 'Supplier\Controller\SupplierController',
            'Supplier\Controller\ProductType' => 'Supplier\Controller\ProductTypeController',
            'Supplier\Controller\Product' => 'Supplier\Controller\ProductController',
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
                    'route'    => '/supplier-list[/][:section]',
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
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-list[/][:productType][/][:supplierId][/][:section]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-add[/][:productType][/][:supplierId][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'add',
                    ),
                ),
            ),
            'product-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'product-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-details[/][:id][/][:section]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'details',
                    ),
                ),
            ),
            'product-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-save',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'save',
                    ),
                ),
            ),
            'product-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-delete',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\Product',
                        'action'     => 'delete',
                    ),
                ),
            ),
            /**
             *  PRODUCT TYPE ROUTES
             */
            'product-type' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-type[/][:action][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-type-list' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-type-list[/][:section][/]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'index',
                    ),
                ),
            ),
            'product-type-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-type-add[/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'add',
                    ),
                ),
            ),
            'product-type-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-type-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'product-type-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product-type-details[/][:id][/][:section]',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'details',
                    ),
                ),
            ),
            'product-type-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-type-save',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
                        'action'     => 'save',
                    ),
                ),
            ),
            'product-type-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/product-type-delete',
                    'defaults' => array(
                        'controller' => 'Supplier\Controller\ProductType',
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
            'formProduct' => __DIR__ . '/../view/supplier/product/form.phtml',
            'productList' => __DIR__ . '/../view/supplier/product/index.phtml',
            'formProductType' => __DIR__ . '/../view/supplier/product-type/form.phtml',
        ),
        'template_path_stack' => array(
            'supplier' => __DIR__ . '/../view',
        ),
    ),
);