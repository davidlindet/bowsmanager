<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Bow\Controller\Bow' => 'Bow\Controller\BowController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'bow' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bow[/][:action][/:id][/][:collectionId][/][:section]',
                    'constraints' => array(
                        'action'        => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'            => '[0-9]+',
                        'collectionId'  => '[0-9]+',
                        'section'       => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'index',
                    ),
                ),
            ),
            'bow-add' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bow-add[/][:collectionId][/][:section]',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'add',
                    ),
                ),
            ),
            'bow-edit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bow-edit[/][:id][/][:section][/][:mode]',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'bow-details' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/bow-details[/][:id][/][:section]',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'details',
                    ),
                ),
            ),
            'bow-save' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/bow-save',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'save',
                    ),
                ),
            ),
            'bow-delete' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/bow-delete',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'delete',
                    ),
                ),
            ),
            'bow-is-done' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/bow-is-done',
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'isDone',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/empty' => __DIR__ . '/../../Application/view/layout/empty.phtml',
            'formBow' => __DIR__ . '/../view/bow/bow/form.phtml',
        ),
        'template_path_stack' => array(
            'bow' => __DIR__ . '/../view',
        ),
    ),
);