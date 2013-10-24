<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Search\Controller\Search' => 'Search\Controller\SearchController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/search[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Search\Controller\Search',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'searchClientList' => __DIR__ . '/../view/search/search/clientList.phtml',
//            'collectionList' => __DIR__ . '/../../Collection/view/collection/collection/index.phtml',
            'searchBowList' => __DIR__ . '/../view/search/search/bowList.phtml',
        ),
        'template_path_stack' => array(
            'search' => __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'highLight' => 'Search\View\Helper\HighLight',
        ),
    ),
);