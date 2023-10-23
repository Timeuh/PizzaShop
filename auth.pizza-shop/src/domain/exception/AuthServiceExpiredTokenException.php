<?php

namespace pizzashop\auth\api\domain\exception;

class AuthServiceExpiredTokenException extends \Exception {
    public function __construct() {
        parent::__construct('Token expiré');
    }
}