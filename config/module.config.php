<?php

namespace Stagem\ZfcCmsPage;

return [

    'templates' =>  [
        'paths' => [
            'content'    => [__DIR__ . '/../view/question'],
            'admin-cms-page'  => [__DIR__ . '/../view/admin/cms-page'],
        ],
    ],

    'view_helpers' => [
        'aliases' => [
            //'content' => View\Helper\ContentHelper::class,
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Model']
            ],
            'orm_default' => [
                'class' => \Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain::class,
                'drivers' => [
                    __NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver'
                ]
            ]
        ],
    ],

];
