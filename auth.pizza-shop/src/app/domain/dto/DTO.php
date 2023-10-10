<?php

namespace pizzashop\auth\api\app\domain\dto;

abstract class DTO {
    public function toJSON(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }
}