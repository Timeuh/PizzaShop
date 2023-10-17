<?php

namespace pizzashop\auth\api\domain\exception;

class SignInUtilisateursException extends \Exception {
    public function __construct() {
        parent::__construct('Erreur SignIn : le mail ou le mot de passe est incorrect');
    }
}