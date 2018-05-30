<?php

namespace Hakstol\Providers;

use Enqueue\SimpleClient\SimpleClient;
use Hakstol\Console\Commands\AmqpConsumeMessagesCommand;
use Hakstol\Contracts\EventOccurredContract;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

/**
 * Class HakstolServiceProvider
 * @package Hakstol\Providers
 */
class HakstolServiceProvider extends ServiceProvider
{
    /**
     * Register the provider
     */
    public function register()
    {
        $this->registerClient();

        $this->registerProcessor();
    }

    /**
     * Register the client
     */
    protected function registerClient()
    {
        $config = $this->getConfig();

        if (false == $config->has('enqueue.client')) {
            return;
        }

        if (false == class_exists(SimpleClient::class)) {
            throw new \LogicException('The enqueue/simple-client package is not installed');
        }

        $this->app->singleton(SimpleClient::class, function() use($config) {

            return new SimpleClient($config->get('enqueue.client'));
        });

        $this->commands(
            [
                AmqpConsumeMessagesCommand::class
            ]
        );
    }

    /**
     * Register the processor
     */
    protected function registerProcessor()
    {
        $config = $this->getConfig();

        $processor = $config->get('enqueue.processor');

        $this->app->resolving(SimpleClient::class, function(SimpleClient $client, Container $app) use($processor) {

            $client->bind($topics, $processor, $app->make($processor));

            return $client;
        });
    }

    protected function bindTopics(SimpleClient $client, Container $container, string $topic, EventOccurredContract $event)
    {
        $client->bind($topic, '', $container->make(''));
    }

    /**
     * @return SimpleClient
     */
    protected function getClient()
    {
        return $this->app->make(SimpleClient::class);
    }

    /**
     * @return mixed
     */
    protected function getConfig()
    {
        return $this->app['config'];
    }
}