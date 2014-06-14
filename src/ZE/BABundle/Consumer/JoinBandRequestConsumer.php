<?php
/**
 * Created by PhpStorm.
 * User: z
 * Date: 13/06/14
 * Time: 21:09
 */

namespace ZE\BABundle\Consumer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\DependencyInjection\Container;

class JoinBandRequestConsumer implements ConsumerInterface
{
    protected $container;
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function execute(AMQPMessage $msg)
    {
        $logger = $this->container->get('logger');
        $logger->info($msg->body);
    }
} 