<?php

namespace ZE\BABundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ZE\BABundle\Socket\Server\MessageSocketServer;
use Ratchet\Http\HttpServer;

use React\EventLoop;
require dirname(__DIR__) . '/../../../vendor/autoload.php';
/**
 * Class SocketServerCommand
 * @package P2\Bundle\RatchetBundle\Command
 */
class SocketServerCommand extends ContainerAwareCommand
{
    /**
     * @var string
     */
    const ARG_ADDRESS = 'address';

    /**
     * @var string
     */
    const ARG_PORT = 'port';

    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('socket:server:start')
            ->setDescription('Starts a web socket server')
            ->addArgument(static::ARG_PORT, InputArgument::OPTIONAL, 'The port to listen on incoming connections')
            ->addArgument(static::ARG_ADDRESS, InputArgument::OPTIONAL, 'The address to listen on')
            ->setHelp(<<<EOT
<info>app/console socket:server:start</info>

  The basic command starts a new websocket server listening on any connections on port 8080
EOT
            );
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $loop   = EventLoop\Factory::create();
        $context = new \ZMQContext($loop);
        $pull = $context->getSocket(\ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
        $app = new MessageSocketServer();
        $pull->on('message', array($app, 'onMessageReceived'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new React\Socket\Server($loop);
        $webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new Ratchet\Server\IoServer(
            new Ratchet\Http\HttpServer(
                new Ratchet\WebSocket\WsServer(
                    new Ratchet\Wamp\WampServer(
                        $app
                    )
                )
            ),
            $webSock
        );

         $loop->run();
    }
}
