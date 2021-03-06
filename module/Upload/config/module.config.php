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
            'upload-bill' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/upload-bill',
                    'defaults' => array(
                        'controller' => 'Upload\Controller\Upload',
                        'action'     => 'bill',
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