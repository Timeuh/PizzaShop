<?php

namespace pizzashop\gate\client;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class ClientApi
{

    protected Client $client;

    public function __construct(array $config = [])
    {
        $this->client = new Client($config);
    }

    public function get($url,$data = [],$headers = [])
    {
        try {
            $options = [
                'json' => $data,
                'headers' => $headers, // Ajoutez les en-têtes reçus de l'API 1
            ];
            $response = $this->client->get($url,$options);
            $jsonContents = $response->getBody()->getContents();

            $responseData = json_decode($jsonContents, true);

            return json_encode($responseData, JSON_PRETTY_PRINT);

        } catch (GuzzleException|RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();

                $body = $response->getBody()->getContents();
                $response = json_decode($body, JSON_PRETTY_PRINT);

                return json_encode($response, JSON_PRETTY_PRINT);

            } else {
                return "Erreur de communication : " . $e->getMessage();
            }
        }
    }

    public function post($url, $data = [], $headers = [])
    {
        try {
            // Créez un tableau d'options pour la requête POST
            $options = [
                'json' => $data,
                'headers' => $headers, // Ajoutez les en-têtes reçus de l'API 1
            ];

            $response = $this->client->post($url, $options);


            return $response->getBody()->getContents();

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                return $response->getBody()->getContents();
            } else {
                return "Erreur de communication : " . $e->getMessage();
            }
        }
    }

    public function patch($url, $data = [], $headers = [])
    {
        try {
            // Créez un tableau d'options pour la requête PATCH
            $options = [
                'json'    => $data,
                'headers' => $headers,
            ];

            $response = $this->client->patch($url, $options);

            return $response->getBody()->getContents();
        } catch (GuzzleException | RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                return $response->getBody()->getContents();
            } else {
                return "Erreur de communication : " . $e->getMessage();
            }
        }
    }


}