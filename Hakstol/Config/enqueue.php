<?php

/**
 *
 * All events are assumed to follow the conventions:
 *
 * 1. The payload includes the name of the event.
 * 2. The corresponding class name of the event is post-fixed with 'Event'.
 * 2. The payload follows the format:
 *
 *      $payload = [
 *          'id'    => 'uuid,
 *          'event' => 'name-of-the-event',
 *          'from'  => 'service-name',
 *          'data'  => [
 *              // data
 *          ];
 *      ];
 *
 *      Note:   The ID can be used as a cross reference between services. The name
 *              of the event that occurred in an external service.
 */

return [

    /**
     * Client settings
     *
     * If there is a different transport preferred, update the configuration
     * to use it. You must also include the transport settings as an array
     * with the key being that of the transport type.
     */
    'client' => [
        'transport' => [
            'default' => env('AMQP_TRANSPORT', 'amqp'),
            'amqp'    => [
                'host'      => env('AMQP_HOST', 'localhost'),
                'port'      => env('AMQP_PORT', 5672),
                'vhost'     => env('AMQP_VHOST', '/'),
                'user'      => env('AMQP_USER', 'user'),
                'pass'      => env('AMQP_PASSWORD', 'pass'),
                'persisted' => env('AMQP_PERSISTED', false),
            ]
        ],
        'client'    => [
            'prefix'                  => env('AMQP_PREFIX', null),
            'app_name'                => env('APP_NAME', 'app'),
            'router_topic'            => env('AMQP_ROUTER_TOPIC', 'default'),
            'router_queue'            => env('AMQP_ROUTER_QUEUE', 'default'),
            'default_processor_queue' => env('AMQP_DEFAULT_PROCESSOR_QUEUE', 'default'),
        ],
    ],

    /**
     * Processor settings
     *
     * - topics:    The topics the service should listen to. (default: none)
     */
    'processor' => [
        'topics' => [
            // 'customer-deleted' => CustomerDeletedEvent::class
        ]
    ]

];