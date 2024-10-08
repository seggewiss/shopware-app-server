<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure();

    $services
        ->load('Segge\\AppServer\\', '../src/*')
        ->exclude('../src/{DependencyInjection,Entity,Migrations,Tests,Kernel.php}');

    $container->import(__DIR__.'/services/services.xml', 'xml');
};
