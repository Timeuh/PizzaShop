<?php

namespace pizzashop\auth\api\app\domain\entities;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $timestamps = false;
    protected $fillable = ['password', 'active', 'activation_token',
        'activation_token_expiration_date', 'refresh_token',
        'refresh_token_expiration_date','reset_passwd_token',
        'reset_passws_token_expiration_date',
        'username'];

    public function toDTO():UserDTO
    {
        return new UserDTO(
            $this->email,
            $this->password,
            $this->active,
            $this->activation_token,
            DateTime::createFromFormat('Y-m-d H:i:s', $this->activation_token_expiration_date),
            $this->refresh_token,
            DateTime::createFromFormat('Y-m-d H:i:s', $this->refresh_token_expiration_date),
            $this->reset_passwd_token,
            DateTime::createFromFormat('Y-m-d H:i:s',$this->reset_passwd_token_expiration_date),
            $this->username,
        );
    }

}