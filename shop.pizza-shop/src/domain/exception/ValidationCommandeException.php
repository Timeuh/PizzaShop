<?php

namespace pizzashop\shop\domain\exception;
use Exception;
use Respect\Validation\Exceptions\NotEmptyException;
use Respect\Validation\Exceptions\NegativeException;
use Respect\Validation\Exceptions\BetweenException;
use Respect\Validation\Exceptions\NumericValException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Exceptions\EmailException;

class ValidationCommandeException extends \Exception {
    public function __construct(ValidationException $e) {
        switch (get_class($e)) {
            case NotEmptyException::class:
                parent::__construct("Le champ ne doit pas être vide.",400);
                break;

            case NegativeException::class:
                parent::__construct("Le champ doit être un nombre positif.",400);
                break;

            case BetweenException::class:
                parent::__construct("Le champ n'est pas compris dans le bonne intervalle.",400);
                break;

            case EmailException::class:
                parent::__construct("L'email est incorrect",400);
                break;

            case NumericValException::class:
                parent::__construct("Le champ doit être un nombre.",400);
                break;

            default:
                parent::__construct("Une erreur de validation s'est produite.",400);
                break;
        }
    }
}



