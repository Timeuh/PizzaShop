<?php

namespace pizzashop\shop\domain\exception;

class commandeNonTrouveeException extends \Exception {
    public function __construct(string $id) {
        parent::__construct("Commande $id non trouvée");
    }
}