<?php
namespace HtaCustomBlocks;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'controllers' => [
      'invokables' => [
          'HtaCustomBlocks\Controller\Admin\Partial' => 'HtaCustomBlocks\Controller\Admin\PartialController',
      ],
    ],
    'block_layouts' => [
        'factories' => [
            'htaPageList' => Service\BlockLayout\HtaPageListFactory::class,
        ],
    ],
    'router' => [
      'routes' => [
          'admin' => [
              'child_routes' => [
                  'hta' => [
                      'type' => 'Segment',
                      'options' => [
                          'route' => '/hta/page-sidebar',
                          'defaults' => [
                              '__NAMESPACE__' => 'HtaCustomBlocks\Controller\Admin',
                              'controller' => 'HtaCustomBlocks\Controller\Admin\Partial',
                              'action' => 'page-sidebar'
                          ],
                      ],  
                  ],
                  [
                      'type' => 'Segment',
                      'options' => [
                          'route' => '/hta/page-options',
                          'defaults' => [
                              '__NAMESPACE__' => 'HtaCustomBlocks\Controller\Admin',
                              'controller' => 'HtaCustomBlocks\Controller\Admin\Partial',
                              'action' => 'page-options'
                          ],
                      ],
                  ],
              ],
          ],
      ],
  ],
];
