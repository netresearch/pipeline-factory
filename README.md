# Netresearch Pipeline Factory Bundle

This bundle enables you to create [league/pipeline](https://github.com/thephpleague/pipeline) pipelines via service
configuration.

## Installation

```bash
$ composer require netresearch/pipeline-factory
```

If you do not use Symfony Flex, you need to enable the bundle manually:

```php
// config/bundles.php
return [
    // ...
    Netresearch\Bundle\PipelineFactoryBundle\NetresearchPipelineFactoryBundle::class => ['all' => true],
];
```

## Usage

Use the pipeline [factory](https://symfony.com/doc/current/service_container/factories.html#static-factories) via your
service container configuration:

```yaml
# config/services.yaml
services:
    app.my.custom.pipeline:
        factory: [ 'Netresearch\ExtendedPipelinesBundle\Pipeline\Factory', create ]
        class: League\Pipeline\Pipeline
        arguments:
            $stages: !iterator [
                '@App\Pipeline\Stages\Stage1',
                '@App\Pipeline\Stages\Stage2',
                '@App\Pipeline\Stages\Stage3',
            ]
            # optional: set the pipeline processor
            $processor: '@App\Pipeline\Processor\MyCustomProcessor'
```

Alternatively you can pass in a collection of tagged services (e.g. tag them
via [autoconfiguration](https://symfony.com/doc/current/service_container/tags.html#autoconfiguring-tags)):

```yaml
# config/services.yaml
services:
    App\Pipeline\Stages\:
        resource: '../src/Pipeline/Stages'
        tags: [ 'app.my.custom.pipeline.stage' ]

    app.my.custom.pipeline:
        factory: [ 'Netresearch\ExtendedPipelinesBundle\Pipeline\Factory', create ]
        class: League\Pipeline\Pipeline
        arguments:
            $stages: !tagged_iterator 'app.my.custom.pipeline.stage'
```

Via [priority](https://symfony.com/doc/current/service_container/tags.html#tagged-services-with-priority) you can
control the order of the stages in this case.

## Development

### Code Style and Static Analysis

Use the following commands to ensure the source code conforms to our **coding standards**
and guidelines:

* `composer phpcs` to check PHP related files against the PSR-12 code style
* `composer rector` to automatically comply with coding standards, simplify and improve
  code, and perform migrations (rules defined in `./rector.php`)
* `composer phpstan` for type and bug checking

Run the command `composer analysis` to run all commands at once.
