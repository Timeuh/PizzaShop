<?php

namespace pizzashop\auth\api\domain\exception;

class InvalidActivationTokenException extends \Exception
{
    public function __construct() {
        parent::__construct('Erreur lors du traitement du token d\'activation');
    }
}