<?php

namespace pizzashop\auth\api\domain\exception;

class UserNotFoundException extends \Exception {
    public function __construct() {
        parent::__construct('Erreur : Profil de l\'utilisateur introuvable');
    }

}