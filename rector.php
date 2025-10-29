<?php

/**
 * See LICENSE file for license details.
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector;
use Rector\DeadCode\Rector\Property\RemoveUselessVarTagRector;
use Rector\Doctrine\Set\DoctrineSetList;
use Rector\Php80\Rector\Class_\AnnotationToAttributeRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\SymfonySetList;
use Rector\Transform\Rector\Attribute\AttributeKeyToClassConstFetchRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src'
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
        SetList::CODE_QUALITY,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        DoctrineSetList::DOCTRINE_CODE_QUALITY,
        DoctrineSetList::ANNOTATIONS_TO_ATTRIBUTES,
        SymfonySetList::SYMFONY_54,
        SymfonySetList::SYMFONY_CODE_QUALITY,
    ])
    ->withRules([
        RemoveUselessParamTagRector::class,
        RemoveUselessReturnTagRector::class,
        RemoveUselessVarTagRector::class
    ])
    ->withSkip([
        // "AnnotationToAttributeRector", which is part of Symfony sets
        AnnotationToAttributeRector::class,
        // "AttributeKeyToClassConstFetchRector", which is part of "DoctrineSetList::DOCTRINE_CODE_QUALITY"
        AttributeKeyToClassConstFetchRector::class
    ]);
