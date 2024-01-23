<?php

require_once __DIR__ . './../../vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq',5672, 'rabbitUser', 'rabbitPass');
$channel = $connection->channel();
$msg = $channel->basic_get($message_queue);
if ($msg) {
    $content = json_decode($msg->body, true);
    print "[x] message reçu : \n" ;
    print_r($content);
    $channel->basic_ack($msg->getDeliveryTag());
    print "\n";
} else {
    print "[x] pas de message reçu\n"; exit(0);
}
$channel->close();
$connection->close();