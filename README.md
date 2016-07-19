# ADMIN BUNDLE
========
Admin Bundle For Symfony version 3

# Version
========
Current version 1.1.0

# Install
========
```
/composer.json

"require": {
	"tnqsoft/admin-bundle": "dev-master",
	"tnqsoft/common-bundle": "dev-master"
},

"repositories": [
    {
        "type"  : "vcs",
        "url"   : "https://github.com/tnqsoft/admin-bundle.git"
    },
    {
        "type"  : "vcs",
        "url"   : "https://github.com/tnqsoft/common-bundle.git"
    }
],
```

```
$ composer update
```

```
/app/AppKernel.php

$bundles = [
	...
	new Symfony\Bundle\AsseticBundle\AsseticBundle(),
	new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
	new Liip\ImagineBundle\LiipImagineBundle(),
	new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
	new Liuggio\ExcelBundle\LiuggioExcelBundle(),
	new TNQSoft\AdminBundle\TNQSoftAdminBundle(),
	new TNQSoft\CommonBundle\TNQSoftCommonBundle(),
]
```

```
/app/config/security.yml

# To get started with security, check out the documentation:
# http://symfony.com/doc/current/book/security.html
security:
    encoders:
        TNQSoft\AdminBundle\Entity\User:
            algorithm: bcrypt
    # http://symfony.com/doc/current/book/security.html#where-do-users-come-from-user-providers
    providers:
        webservice:
            id: tnqsoft_admin.security.provider.webservice_user

    #http://symfony.com/doc/current/book/security.html#security-encoding-password
    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN:
            - ROLE_ADMIN
            - ROLE_ALLOWED_TO_SWITCH

    firewalls:
        # disables authentication for assets and the profiler, adapt it according to your needs
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        login_firewall:
            pattern:   ^/admin/login$
            anonymous: ~

        admin:
            pattern:    ^/admin
            provider: webservice
            form_login:
                check_path: login_check
                login_path: login
                default_target_path: admin_dashboard
            logout:
                path:   logout # a route called logout
                target: login
            remember_me:
                secret:   '%secret%'
                lifetime: 604800 # 1 week in seconds
                path:     /
            # activate different ways to authenticate

            # http_basic: ~
            # http://symfony.com/doc/current/book/security.html#a-configuring-how-your-users-will-authenticate

            # form_login: ~
            # http://symfony.com/doc/current/cookbook/security/form_login_setup.html

        main:
            pattern:   ^/
            anonymous: ~

    access_control:
        - { path: ^/admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/, roles: IS_AUTHENTICATED_ANONYMOUSLY }

```

```
/app/config/routing.yml

admin:
    resource: "@TNQSoftAdminBundle/Resources/config/routing.yml"

_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
```

```
/app/config/config.yml

imports:
	- { resource: "@TNQSoftAdminBundle/Resources/config/parameters.yml" }

parameters:
    locale: vi

framework:
	translator:      { fallbacks: ["%locale%"] }
	serializer:      { enable_annotations: true }

twig:
    debug:            "%kernel.debug%"
    strict_variables: "%kernel.debug%"
    exception_controller: TNQSoftCommonBundle:Exception:showException
    globals:
        app_admin_ver: "%app_admin_ver%"

# Doctrine Configuration
doctrine:
    dbal:
        default_connection: default
        connections:
            default:
                driver:   pdo_mysql
                host:     "%database_host%"
                port:     "%database_port%"
                dbname:   "%database_name%"
                user:     "%database_user%"
                password: "%database_password%"
                charset:  UTF8
                # if using pdo_sqlite as your database driver:
                #   1. add the path in parameters.yml
                #     e.g. database_path: "%kernel.root_dir%/data/data.db3"
                #   2. Uncomment database_path in parameters.yml.dist
                #   3. Uncomment next line:
                #     path:     "%database_path%"

    orm:
        default_entity_manager: default
        entity_managers:
            default:
                connection: default
                #auto_generate_proxy_classes: "%kernel.debug%"
                naming_strategy: doctrine.orm.naming_strategy.underscore
                auto_mapping: true
                mappings:
                    gedmo_translatable:
                        type: annotation
                        prefix: Gedmo\Translatable\Entity
                        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Translatable/Entity"
                        alias: GedmoTranslatable # (optional) it will default to the name set for the mapping
                        is_bundle: false
                    gedmo_translator:
                        type: annotation
                        prefix: Gedmo\Translator\Entity
                        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Translator/Entity"
                        alias: GedmoTranslator # (optional) it will default to the name set for the mapping
                        is_bundle: false
                    gedmo_loggable:
                        type: annotation
                        prefix: Gedmo\Loggable\Entity
                        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Loggable/Entity"
                        alias: GedmoLoggable # (optional) it will default to the name set for the mappingmapping
                        is_bundle: false
                    gedmo_tree:
                        type: annotation
                        prefix: Gedmo\Tree\Entity
                        dir: "%kernel.root_dir%/../vendor/gedmo/doctrine-extensions/lib/Gedmo/Tree/Entity"
                        alias: GedmoTree # (optional) it will default to the name set for the mapping
                        is_bundle: false

# Swiftmailer Configuration
swiftmailer:
    transport: "%mailer_transport%"
    host:      "%mailer_host%"
    username:  "%mailer_user%"
    password:  "%mailer_password%"
    spool:     { type: memory }

assetic:
    debug:          '%kernel.debug%'
    use_controller: '%kernel.debug%'
    filters:
        cssrewrite: ~

doctrine_migrations:
    dir_name: "%kernel.root_dir%/DoctrineMigrations"
    namespace: Application\Migrations
    table_name: migration_versions
    name: Application Migrations

stof_doctrine_extensions:
    default_locale: %locale%
    orm:
        default:
            tree: true

liip_imagine:
    resolvers:
       default:
          web_path: ~

    filter_sets:
        cache: ~
        thumb_Autox32:
            quality: 90
            filters:
                relative_resize: { heighten: 32 }
        thumb_60x45:
            quality: 75
            filters:
                thumbnail: { size: [60, 45], mode: outbound }
        thumb_60x60:
            quality: 90
            filters:
                thumbnail: { size: [60, 60], mode: outbound }
        thumb_100x75:
            quality: 75
            filters:
                thumbnail: { size: [100, 75], mode: outbound }
        thumb_140x60:
            quality: 90
            filters:
                thumbnail: { size: [140, 60], mode: outbound }
        thumb_120x120:
            quality: 90
            filters:
                thumbnail: { size: [120, 120], mode: outbound }
        thumb_200x150:
            quality: 90
            filters:
                thumbnail: { size: [200, 150], mode: outbound }
        thumb_330x250:
            quality: 90
            filters:
                thumbnail: { size: [330, 250], mode: outbound }
        thumb_320xAuto:
            quality: 90
            filters:
                relative_resize: { widen: 320 }
        watermark:
            filters:
                watermark:
                    # Relative path to the watermark file (prepended with "%kernel.root_dir%/")
                    image: "%kernel.root_dir%/../web/shop1/img/watermark.png"
                    # Size of the watermark relative to the origin images size
                    size: 0.5
                    # Position: One of topleft,top,topright,left,center,right,bottomleft,bottom,bottomright
                    position: bottomright
        #COKHITRONGTIIN
        thumb_100x100:
            quality: 90
            filters:
                thumbnail: { size: [100, 100], mode: outbound }
        thumb_150x150:
            quality: 90
            filters:
                thumbnail: { size: [150, 150], mode: outbound }
        thumb_280x220:
            quality: 90
            filters:
                thumbnail: { size: [280, 220], mode: outbound }
        thumb_300x300:
            quality: 90
            filters:
                thumbnail: { size: [300, 300], mode: outbound }
        thumb_400x300:
            quality: 90
            filters:
                thumbnail: { size: [400, 300], mode: outbound }
                # watermark:
                #     image: "%kernel.root_dir%/../web/shop1/img/watermark.png"
                #     size: 0.5
                #     position: bottomright
        thumb_600x600:
            quality: 90
            filters:
                thumbnail: { size: [600, 600], mode: outbound }

tnq_soft_admin:
    component_enabled:
        banner: true
        menu: true
        page: true
        news_category: true
        news: true
        partner: true
        product_category: true
        product: true
        sale: true
        testimonial: true
        photo: true
```

```
php bin/console cache:clear --env=dev
php bin/console assets:install --symlink web
php bin/console assetic:dump --env=dev
php bin/console doctrine:schema:update --force
php bin/console tuanquynh:user:create admin 123 tuanquynh0508@gmail.com
```
