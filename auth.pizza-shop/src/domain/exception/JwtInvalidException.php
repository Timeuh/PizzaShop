<?php

namespace pizzashop\auth\api\domain\exception;

class JwtInvalidException extends \Exception {
    private array $messages = [
        'signature' => 'la vérification de signature du token a échoué',
        'invalid' => 'le token fourni n\'est pas un jwt valide'
    ];

    public function __construct(string $type) {
        parent::__construct('JWT Erreur : ' . $this->messages[$type]);
    }
}