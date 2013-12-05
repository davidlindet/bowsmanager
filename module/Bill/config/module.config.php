<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bill\Controller\Bill' => 'Bill\Controller\BillController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'bill' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bill[/][:action][/:id][/][:collectionId][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'            => '[0-9]+',
                        'collectionId'  => '[0-9]+',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'index',
                    ),
                ),
            ),
            'bill-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bill-add[/][:collectionId][/][:section]',
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'add',
                    ),
                ),
            ),
            'bill-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bill-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'bill-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bill-details[/][:id][/][:section]',
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'details',
                    ),
                ),
            ),
            'bill-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/bill-save',
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'save',
                    ),
                ),
            ),
            'bill-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/bill-delete',
                    'defaults' => array(
                        'controller' => 'Bill\Controller\Bill',
                        'action'     => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'formBill' => __DIR__ . '/../view/bill/bill/form.phtml',
        ),
        'template_path_stack' => array(
            'bill' => __DIR__ . '/../view',
        ),
    ),
);