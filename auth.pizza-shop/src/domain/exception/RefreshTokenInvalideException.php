<?php

namespace pizzashop\auth\api\domain\exception;

class RefreshTokenInvalideException extends \Exception {
    public function __construct() {
        parent::__construct('Erreur refresh : le refresh token renseigné est invalide');
    }
}