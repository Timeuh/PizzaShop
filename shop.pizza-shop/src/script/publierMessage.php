<?php

require_once __DIR__ . './../../vendor/autoload.php';

use PhpAmqpLib\Message\AMQPMessage;



$message_queue = 'nouvelles_commandes';
$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', 5672, 'rabbitUser', 'rabbitPass');
$channel = $connection->channel();
$msg_body = [
    'id' => 1,
    'nom' => 'Pizza 4 fromages',
    'prix' => 12.5,
    'ingredients' => [
        'Mozzarella',
        'Gorgonzola',
        'Chèvre',
        'Parmesan'
]];
$channel->basic_publish(new AMQPMessage(json_encode($msg_body)), 'pizzashop', 'nouvelle');
print "[x] commande publiée : \n";
$channel->close();
$connection->close();