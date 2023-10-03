<?php
use Monolog\Logger;

return[
    'log.name' => 'commande.log',
    'log.file' => __DIR__.'/../../src/console/commande.log',
    'log.level' => Logger::WARNING,
];