<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Phpdoc\GeneralPhpdocAnnotationRemoveFixer;
use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(GeneralPhpdocAnnotationRemoveFixer::class)
             ->call('configure', [
                 [
                     'annotations' => [
                         'throws',
                         'author',
                         'package',
                         'group',
                         'required',
                         'phpstan-ignore-line',
                         'phpstan-ignore-next-line',
                     ],
                 ],
             ]);

    $services->set(NoSuperfluousPhpdocTagsFixer::class)
             ->call('configure', [
                 [
                     'allow_mixed' => true,
                 ],
             ]);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/ecs.php',
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $parameters->set(Option::SETS, [SetList::PSR_12, SetList::SYMPLIFY, SetList::COMMON, SetList::CLEAN_CODE]);
};
