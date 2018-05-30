<?php

namespace Hakstol\Console\Commands;

use Enqueue\SimpleClient\SimpleClient;
use Enqueue\Symfony\Client\ConsumeMessagesCommand;

/**
 * Class AmqpConsumeMessagesCommand
 * @package Hakstol\Console\Commands
 */
class AmqpConsumeMessagesCommand extends ConsumeMessagesCommand
{
    /**
     * Create a new command instance.
     *
     * @param SimpleClient $client
     */
    public function __construct(SimpleClient $client)
    {
        parent::__construct(
            $client->getQueueConsumer(),
            $client->getDelegateProcessor(),
            $client->getQueueMetaRegistry(),
            $client->getDriver()
        );
    }
}