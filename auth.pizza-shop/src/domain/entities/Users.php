<?php

namespace pizzashop\auth\api\domain\entities;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use pizzashop\auth\api\domain\dto\UserDTO;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $timestamps = false;
    protected $fillable = ['password', 'active', 'activation_token',
        'activation_token_expiration_date', 'refresh_token',
        'refresh_token_expiration_date','reset_passwd_token',
        'reset_passwd_token_expiration_date',
        'username'];

    public function toDTO():UserDTO
    {
        return new UserDTO(
            $this->email,
            $this->useername,
        );
    }

}