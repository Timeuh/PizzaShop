<?php

namespace pizzashop\auth\api\domain\dto;


use DateTime;

class UserDTO extends DTO {
    public string $email;
    public string $password;
    public bool $active;
    public string $activation_token;
    public DateTime $activation_token_expiration_date;
    public string $refresh_token;
    public DateTime $refresh_token_expiration_date;
    public string $reset_password_token;
    public DateTime $reset_password_token_expiration_date;
    public string $username;

    /**
     * @param string $email
     * @param string $password
     * @param bool $active
     * @param string $activation_token
     * @param DateTime $activation_token_expiration_date
     * @param string $refresh_token
     * @param DateTime $refresh_token_expiration_date
     * @param string $reset_password_token
     * @param DateTime $reset_password_token_expiration_date
     * @param string $username
     */
    public function __construct(string $email, string $password, bool $active, string $activation_token, DateTime $activation_token_expiration_date, string $refresh_token, DateTime $refresh_token_expiration_date, string $reset_password_token, DateTime $reset_password_token_expiration_date, string $username) {
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->activation_token = $activation_token;
        $this->activation_token_expiration_date = $activation_token_expiration_date;
        $this->refresh_token = $refresh_token;
        $this->refresh_token_expiration_date = $refresh_token_expiration_date;
        $this->reset_password_token = $reset_password_token;
        $this->reset_password_token_expiration_date = $reset_password_token_expiration_date;
        $this->username = $username;
    }
}