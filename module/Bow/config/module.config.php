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
                    'route'    => '/bow[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Bow\Controller\Bow',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'formBow' => __DIR__ . '/../view/bow/bow/form.phtml',
        ),
        'template_path_stack' => array(
            'bow' => __DIR__ . '/../view',
        ),
    ),
);