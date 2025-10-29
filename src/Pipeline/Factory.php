<?php

/**
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace Netresearch\PipelineFactoryBundle\Pipeline;

use League\Pipeline\PipelineBuilder;
use League\Pipeline\PipelineInterface;
use League\Pipeline\ProcessorInterface;
use League\Pipeline\StageInterface;

class Factory
{
    /**
     * @param iterable<StageInterface> $stages
     */
    public static function create(iterable $stages, ?ProcessorInterface $processor): PipelineInterface
    {
        $builder = new PipelineBuilder();
        foreach ($stages as $index => $stage) {
            // Runtime validation despite PHPDoc type hint - ensures type safety when stages come from
            // configuration, service containers, or other dynamic sources where types aren't guaranteed
            /** @phpstan-ignore-next-line instanceof.alwaysTrue - intentional runtime validation */
            if (!$stage instanceof StageInterface) {
                throw new \InvalidArgumentException(sprintf(
                    'Stage at position %d must implement %s, got %s',
                    $index,
                    StageInterface::class,
                    get_debug_type($stage)
                ));
            }
            $builder->add($stage);
        }

        return $builder->build($processor);
    }
}
