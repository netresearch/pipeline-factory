<?php

/**
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace Netresearch\PipelineFactoryBundle\Tests\Pipeline;

use League\Pipeline\PipelineInterface;
use League\Pipeline\ProcessorInterface;
use League\Pipeline\StageInterface;
use Netresearch\PipelineFactoryBundle\Pipeline\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    /**
     * Test that factory creates pipeline with valid stages
     */
    public function testCreateWithValidStages(): void
    {
        $stage1 = $this->createMock(StageInterface::class);
        $stage2 = $this->createMock(StageInterface::class);
        $stage3 = $this->createMock(StageInterface::class);

        $stages = [$stage1, $stage2, $stage3];
        $processor = null;

        $pipeline = Factory::create($stages, $processor);

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * Test that factory creates pipeline with custom processor
     */
    public function testCreateWithCustomProcessor(): void
    {
        $stage = $this->createMock(StageInterface::class);
        $processor = $this->createMock(ProcessorInterface::class);

        $stages = [$stage];

        $pipeline = Factory::create($stages, $processor);

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * Test that factory accepts iterable stages (not just arrays)
     */
    public function testCreateWithIterableStages(): void
    {
        $stage1 = $this->createMock(StageInterface::class);
        $stage2 = $this->createMock(StageInterface::class);

        // Create ArrayIterator to test iterable support
        $stages = new \ArrayIterator([$stage1, $stage2]);

        $pipeline = Factory::create($stages, null);

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * Test that factory works with generator functions
     */
    public function testCreateWithGeneratorStages(): void
    {
        $stageGenerator = function (): \Generator {
            yield $this->createMock(StageInterface::class);
            yield $this->createMock(StageInterface::class);
        };

        $pipeline = Factory::create($stageGenerator(), null);

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * Test that pipeline can be executed with valid payload
     */
    public function testPipelineExecution(): void
    {
        // Create a stage that transforms input
        $stage = new class implements StageInterface {
            public function __invoke(mixed $payload): mixed
            {
                return $payload . '-processed';
            }
        };

        $stages = [$stage];
        $pipeline = Factory::create($stages, null);

        $result = $pipeline->process('input');

        $this->assertSame('input-processed', $result);
    }

    /**
     * Test that multiple stages are executed in sequence
     */
    public function testMultipleStagesExecutionOrder(): void
    {
        $stage1 = new class implements StageInterface {
            public function __invoke(mixed $payload): mixed
            {
                return $payload . '-stage1';
            }
        };

        $stage2 = new class implements StageInterface {
            public function __invoke(mixed $payload): mixed
            {
                return $payload . '-stage2';
            }
        };

        $stage3 = new class implements StageInterface {
            public function __invoke(mixed $payload): mixed
            {
                return $payload . '-stage3';
            }
        };

        $stages = [$stage1, $stage2, $stage3];
        $pipeline = Factory::create($stages, null);

        $result = $pipeline->process('start');

        $this->assertSame('start-stage1-stage2-stage3', $result);
    }

    /**
     * Test that empty stages array is handled
     * NOTE: Current implementation does not validate empty stages
     * This test documents current behavior
     */
    public function testCreateWithEmptyStages(): void
    {
        $stages = [];
        $pipeline = Factory::create($stages, null);

        $this->assertInstanceOf(PipelineInterface::class, $pipeline);

        // Empty pipeline returns input unchanged
        $result = $pipeline->process('test');
        $this->assertSame('test', $result);
    }

    /**
     * Test that single stage works correctly
     */
    public function testCreateWithSingleStage(): void
    {
        $stage = new class implements StageInterface {
            public function __invoke(mixed $payload): mixed
            {
                return strtoupper($payload);
            }
        };

        $stages = [$stage];
        $pipeline = Factory::create($stages, null);

        $result = $pipeline->process('test');
        $this->assertSame('TEST', $result);
    }
}
