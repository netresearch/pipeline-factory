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
     * @param array<StageInterface> $stages
     */
    public static function create(iterable $stages, ?ProcessorInterface $processor): PipelineInterface
    {
        $builder = new PipelineBuilder();
        foreach ($stages as $stage) {
            $builder->add($stage);
        }

        return $builder->build($processor);
    }
}
