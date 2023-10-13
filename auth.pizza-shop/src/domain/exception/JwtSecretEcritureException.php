<?php

namespace pizzashop\auth\api\domain\exception;

use Exception;

class JwtSecretEcritureException extends Exception {
    public function __construct() {
        parent::__construct('Erreur lors de l\'écriture de la variable d\'environnement pour le secret JWT');
    }
}