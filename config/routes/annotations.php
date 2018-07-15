<?php
// original YAML config
//controllers:
//resource: ../../src/Controller/
//type: annotation
//    prefix:
//        cs: '' # don't prefix URLs for English, the default locale
//        en: '/en'

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {
    /* @var $kernel \App\Kernel*/
    global $kernel;

    $routes
        ->import('../../src/Controller/', 'annotation')
            ->prefix(
                $kernel->getContainer()->getParameter('locales_to_url_prefixes')
            );
};