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
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/account/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'login'
                    )
                )
            ),
            'proceed-login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/account/proceed-login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'proceed-login'
                    )
                )
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/account/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'logout'
                    )
                )
            ),
            'registration' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/account/registration',
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'registration'
                    )
                )
            ),
            'activation' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account/activation/[:email[/:token]]',
                    'constraints' => array(
                        'email' => '[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+',
                        'token' => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'activation'
                    )
                )
            ),
            'password-recovery' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/account/password-recovery',
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'password-recovery'
                    )
                )
            ),
            'password-reset' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/account/password-reset/[:email[/:token]]',
                    'constraints' => array(
                        'email' => '[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+',
                        'token' => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'base\Controller',
                        'controller' => 'Auth',
                        'action' => 'password-reset'
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory'
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator'
        )
    ),
    'translator' => array(
        'locale' => 'pl_PL',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo'
            )
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'base\Controller\Auth' => 'base\Controller\AuthController'
        )
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'base/error/404',
        'exception_template' => 'base/error/index',
        'template_map' => array(
            'base/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'base/error/404' => __DIR__ . '/../view/error/404.phtml',
            'base/error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    'module_layouts' => array(
        'base' => 'base/layout',
    ),
    'module_error_layouts' => array(
        'base' => array(
            'not_found_template' => 'base/error/404',
            'exception_template' => 'base/error/index'
        )
    ),
    'view_helpers' => array(
        'invokables' => array(
            'phone_number' => 'base\View\Helper\PhoneNumberHelper'
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'forceHttp' => 'base\Controller\Plugin\ForceHttp',
            'forceHttps' => 'base\Controller\Plugin\ForceHttps',
            'getAuthService' => 'base\Controller\Plugin\AuthService',
            'getEntityManager' => 'base\Controller\Plugin\EntityManager',
            'encrypt' => 'base\Controller\Plugin\Encryption'
        )
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array()
        )
    ),
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'base\Entity\Account',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function (base\Entity\Account $account, $password) {
                    if (password_verify($password, $account->getPassword()) && $account->isActive()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            )
        ),
        'driver' => array(
            'base_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/base/Entity'
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'base\Entity' => 'base_entities'
                )
            )
        )
    )
);
