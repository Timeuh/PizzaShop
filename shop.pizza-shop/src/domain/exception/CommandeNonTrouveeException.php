<?php

namespace pizzashop\shop\domain\exception;

class CommandeNonTrouveeException extends \Exception {
    public function __construct(string $id) {
        parent::__construct("Commande $id non trouvée",404);
    }
}