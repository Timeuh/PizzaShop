<?php

namespace pizzashop\auth\api\domain\entities;
use Illuminate\Database\Eloquent\Model;
use pizzashop\auth\api\domain\dto\UserDTO;

class Users extends Model
{
    protected $connection = 'auth';
    protected $table = 'users';
    protected $primaryKey = 'email';
    protected $keyType = 'string';
    public $timestamps = false;
    public function toDTO():UserDTO
    {
        return new UserDTO(
            $this->email,
            $this->username
        );
    }

}