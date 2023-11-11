<?php

namespace pizzashop\shop\domain\service\authentification;

use Exception;
use GuzzleHttp\Client;
use pizzashop\shop\domain\exception\TokenInvalidException;


class ServiceAuth
{

    private Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function checkTokenJwt(array $token)
    {
        try {
            $check = $this->client->get('/api/users/validate', ['headers' => ['Authorization' => $token]]);
            return json_decode($check->getBody(), true);
        } catch (Exception $e) {
            throw new TokenInvalidException();
        }
    }


}