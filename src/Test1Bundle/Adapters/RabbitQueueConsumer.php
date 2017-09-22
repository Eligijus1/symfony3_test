<?php

namespace Test1Bundle\Adapters;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitQueueConsumer implements ConsumerInterface
{

    /**
     * @param AMQPMessage $msg The message
     *
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        /*
        if (!empty($msg)) {
            $payload = json_decode(unserialize($msg->body));

            echo sprintf("Calling %s for %s with: '%s'\n", $payload->endpoint, $payload->handle, $payload->text);
        }
        */
        $payload = json_decode(unserialize($msg->body));

        echo sprintf("Calling %s for %s with: '%s'\n", $payload->endpoint, $payload->handle, $payload->text);

        return true;
    }
}
