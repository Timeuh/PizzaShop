
<?php
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . './../../vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', 5672, 'rabbitUser', 'rabbitPass');
$channel = $connection->channel();
$callback = function(AMQPMessage $msg) {
    $content = json_decode($msg->body, true);
    print "[x] message reçu : \n" ;
    print_r($content);
    $msg->getChannel()->basic_ack($msg->getDeliveryTag());
    print "\n";
};
$msg = $channel->basic_consume($message_queue, '', false, false, false, false, $callback );
try {
    $channel->consume();
} catch (Exception $e) { print $e->getMessage();
}
$channel->close(); $connection->close();