<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Upload\Controller\Upload' => 'Upload\Controller\UploadController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'upload' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/upload[/][:action]',
                    'constraints' => array(
                        'action'   => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Upload\Controller\Upload',
                        'action'     => 'index',
                    ),
                ),
            ),
            'upload-collection' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/upload-collection',
                    'defaults' => array(
                        'controller' => 'Upload\Controller\Upload',
                        'action'     => 'collection',
                    ),
                ),
            ),
            'upload-bow' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/upload-bow',
                    'defaults' => array(
                        'controller' => 'Upload\Controller\Upload',
                        'action'     => 'bow',
                    ),
                ),
            ),
        ),
    ),
);