<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([__DIR__ . '/ecs.php', __DIR__ . '/rector.php', __DIR__ . '/src'])
    ->withRootFiles()
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true,
    );
