<?php

namespace Test1Bundle\Adapters;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class RabbitQueueProducer
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * RabbitQueueProducer constructor.
     *
     * @param Producer $producer
     */
    public function __construct($producer)
    {
        $this->producer = $producer;
    }

    public function publish($message)
    {
        //$this->producer->publish(serialize($message));
        $this->producer->publish(serialize($message), 'symfony3_test_1_key_1');
        //$this->producer->publish(serialize($message), 'statuses/update');
    }
}