<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /user/:controller/:action
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'user\Controller\Calendar',
                        'action' => 'index'
                    )
                )
            ),
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'user\Controller\Calendar',
                        'action' => 'index'
                    )
                )
            ),
            'user-dashboard' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'Dashboard',
                        'action' => 'index',
                        'acl' => false
                    )
                )
            ),
            'user-calendar' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/calendar',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'Calendar',
                        'action' => 'index',
                        'acl' => false
                    )
                )
            ),
            'user-profile-view' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user/profile/view',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'Profile',
                        'action' => 'view',
                        'acl' => false
                    )
                )
            ),
            'user' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        '__NAMESPACE__' => 'user\Controller',
                        'controller' => 'Dashboard',
                        'action' => 'index',
                        'acl' => false
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    ),
                    'default-value' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'user\Controller\Dashboard' => 'user\Controller\DashboardController',
            'user\Controller\Calendar'  => 'user\Controller\CalendarController',
            'user\Controller\Profile'   => 'user\Controller\ProfileController'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'user/layout' => __DIR__ . '/../view/layout/layout.phtml'
        ),
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view'
        )
    ),
    'module_layouts' => array(
        'user' => 'user/layout'
    )
);
