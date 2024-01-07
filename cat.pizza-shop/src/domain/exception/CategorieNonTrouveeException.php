<?php

namespace pizzashop\cat\domain\exception;

class CategorieNonTrouveeException extends \Exception {

    public function __construct(string $id) {
        parent::__construct("La catégorie $id n'a pas été trouvé",404);
    }
}