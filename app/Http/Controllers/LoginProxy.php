<?php

namespace App\Http\Controllers;


use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\UnauthorizedException;
use URL;

class LoginProxy
{
    public static function attemptLogin($email,$password){
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->post(URL::to('/oauth/token')
                , ['form_params' => [
                    'grant_type' => 'password',
                    'client_id' => env('PASSWORD_CLIENT_ID'),
                    'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                    'username' => $email,
                    'password' => $password,
                    'grant' => '*'
                ]
                ]);
        } catch (ClientException $e) {
            $data = ['message' => 'Tus credenciales son incorrectas' , 'status' => '401'];
            return $data;
        }

        $responseBody = \GuzzleHttp\json_decode($response->getBody());
        $data = [
            'access_token'  => $responseBody->access_token,
            'expires_in'    => $responseBody->expires_in,
            'status'        => '200'
        ];
        return $data;
    }

}