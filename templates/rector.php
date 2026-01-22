<?php
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__,
    ])
    ->withSkip([
        __DIR__ . '/node_modules/*',
        __DIR__ . '/vendor/*',
        // Также можно исключить минифицированные JS/CSS, если они попадают в сканирование
        __DIR__ . '/assets/*',
    ])
    // Target PHP 8.5 specifically
    ->withPhpSets(php85: true)
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true
    );
