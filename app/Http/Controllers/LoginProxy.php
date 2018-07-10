<?php

namespace App\Http\Controllers;


use Illuminate\Validation\UnauthorizedException;

class LoginProxy
{
    public static function attemptLogin($email,$password){
        $client = new \GuzzleHttp\Client();
        $response = $client->post(env('APP_URL').'/oauth/token'
            ,['form_params' => [
                'grant_type'    => 'password',
                'client_id'     => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'username'      => $email,
                'password'      => $password,
                'grant'         => '*'
            ]
            ]);

        $responseBody = \GuzzleHttp\json_decode($response->getBody());
        $data = [
            'access_token'  => $responseBody->access_token,
            'expires_in'    => $responseBody->expires_in
        ];
        return $data;
    }

}