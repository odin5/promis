<?php
/* I've chosen PHP format of config instead of YAML format for little bit more flexibility, even though
 * services like database are not available yet
 */
/* @var $container \Symfony\Component\DependencyInjection\ContainerBuilder */

/* @var $em \Doctrine\ORM\EntityManager*/
//$em = $container->get('doctrine.orm.default_entity_manager');
//var_dump($container);exit;

$config = [
    // https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    'encoders' => [
        'App\Entity\User' => [
            'algorithm' => 'bcrypt',
            'cost' => 12,
        ],
    ],

    'role_hierarchy' => [
        'ROLE_STUDENT' => [ 'ROLE_USER' ],
        'ROLE_TEACHER' => [ 'ROLE_STUDENT' ],
        'ROLE_ADMIN' => [ 'ROLE_TEACHER' ],
        'ROLE_SUPER_ADMIN' => [ 'ROLE_ADMIN', 'ROLE_ALLOWED_TO_SWITCH' ],
    ],

    'providers' => [
        //'in_memory' => [ 'memory' => null ]
        'users' => [
            'entity' => [ 'class' => '\App\Entity\User', 'property' => 'username' ],
        ],
    ],

    // https://symfony.com/doc/current/security/voters.html#changing-the-access-decision-strategy
    'access_decision_manager' => [
        'strategy' => 'affirmative', // default - grant access as soon as there is one voter granting access
    ],

    'firewalls' => [
        'dev' => [
            'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
            'security' => false,
        ],

        //'main' => [
        //    'anonymous' => true
        //],

        'login' => [
            'pattern' => '^/(\w\w/)?login$',
            'security' => false,
        ],

        'secured_area' => [
            'pattern' => '^/',
            'form_login' => [
                'check_path' => 'login_check',
                'login_path' => 'login',
                'default_target_path' => 'index',
                'always_use_default_target_path' => true,
            ],
            'logout' => [
                'path' => 'logout',
                'target' => 'login',
            ],
            'remember_me' => [
                'secret' => '%kernel.secret%',
                'lifetime' => 60 * 60 * 24 * 7, // 1 week in seconds
                'path' => '/',
                // by default, the feature is enabled by checking a
                // checkbox in the login form (see below), uncomment the
                // following line to always enable it.
                //'always_remember_me' => true,
            ],
            'http_basic' => true,
            // 'https://symfony.com/doc/current/security.html#a-configuring-how-your-users-will-authenticate

            //'form_login' => true
            // 'https://symfony.com/doc/current/security/form_login_setup.html
        ],
    ],

    // Easy way to control access for large sections of your site
    // Note: Only the *first* access control that matches will be used
    'access_control' => [
        [ 'path' => '^/(\w\w/)?login', 'role' => 'IS_AUTHENTICATED_ANONYMOUSLY'],
        [ 'path' => '^/_trans', 'role' => 'ROLE_SUPER_ADMIN' ],
        [ 'path' => '^/', 'role' => 'IS_AUTHENTICATED_REMEMBERED' ],
        //[ 'path' => '^/admin', 'role' => 'ROLE_ADMIN' ],
        //[ 'path' => '^/profile', 'role' => 'ROLE_USER' ]
    ],
];

if($container->getParameter('kernel.environment') === 'prod' && $_SERVER['SERVER_NAME'] != 'promis.local') {
    foreach($config['access_control'] as &$rule) {
        $rule['requires_channel'] = 'https';
    }
}

$container->loadFromExtension('security', $config);

/* original YAML config
security:
    # https://symfony.com/doc/current/security.html#where-do-users-come-from-user-providers
    encoders:
        App\Entity\User:
            algorithm: bcrypt
            cost:      12

    role_hierarchy:
        ROLE_ADMIN:       ROLE_STUDENT
        ROLE_SUPER_ADMIN: [ROLE_STUDENT, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    providers:
        #in_memory: { memory: ~ }
        users:
            entity: { class: \App\Entity\User, property: username }

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        #main:
        #    anonymous: true

        login:
            pattern:  ^/(\w\w/)?login$
            security: false

        secured_area:
            pattern:    ^/
            form_login:
                check_path: login_check
                login_path: login
                default_target_path: index
                always_use_default_target_path: true
            logout:
                path:   logout
                target: login
            remember_me:
                secret:   '%kernel.secret%'
                lifetime: 604800 # 1 week in seconds
                path:     /
                # by default, the feature is enabled by checking a
                # checkbox in the login form (see below), uncomment the
                # following line to always enable it.
                #always_remember_me: true

            # http_basic: true
            # https://symfony.com/doc/current/security.html#a-configuring-how-your-users-will-authenticate

            # form_login: true
            # https://symfony.com/doc/current/security/form_login_setup.html

    # Easy way to control access for large sections of your site
    # Note: Only the *first* access control that matches will be used
    access_control:
        - { path: ^/(\w\w/)?login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/_trans, roles: ROLE_SUPER_ADMIN }
        - { path: ^/, roles: IS_AUTHENTICATED_REMEMBERED }
        # - { path: ^/admin, roles: ROLE_ADMIN }
        # - { path: ^/profile, roles: ROLE_USER }
*/