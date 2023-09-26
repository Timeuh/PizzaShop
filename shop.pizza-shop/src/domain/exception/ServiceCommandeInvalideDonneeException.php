<?php

namespace pizzashop\shop\domain\exception;

class ServiceCommandeInvalideDonneeException extends \Exception {
    public function __construct(string $id) {
        parent::__construct("Probleme au niveau des items" );
    }
}