<?php

namespace pizzashop\auth\api\domain\dto;

class CredentialsDTO extends DTO {

    public string $email;
    public string $password;

    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}