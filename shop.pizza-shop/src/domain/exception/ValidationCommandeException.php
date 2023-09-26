<?php

namespace pizzashop\shop\domain\exception;

class ValidationCommandeException extends \Exception {
    public function __construct(\Exception $e) {
        switch ($e)
        return $e->getMessage();
    }
}