<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Nette\Set\NetteSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(NetteSetList::NETTE_30);

    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__ . '/source']);
};
