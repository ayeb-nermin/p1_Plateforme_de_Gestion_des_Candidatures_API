<?php

namespace App\Traits;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use Laravel\Passport\Client;
use Laravel\Passport\Exceptions\OAuthServerException;

/**
 * Auth trait has all methods for authentication
 * Methods : create tokens , refresh tokens for all types of users (api users , app users , app clients).
 */
trait AuthTrait
{
    /**
     * Generate token
     */
    public function getTokenAndRefreshToken($email, $password, $provider)
    {
        $data = [
            'grant_type' => 'password',
            'username' => $email,
            'password' => $password,
            // 'scope' => $scope,
        ];

        return $this->oauthRequest('POST', config('app.url') . '/oauth/token', $data, $provider);
    }
    /**
     * Refresh Token.
     */
    public function getRefreshedToken($token, $provider)
    {
        $data = [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token,
            // 'scope' => $scope,
        ];
        return $this->oauthRequest('POST', config('app.url') . '/oauth/token', $data, $provider);
    }
    /**
     * Oauth request.
     */
    public function oauthRequest($method, $path, $data, $provider)
    {
        $oClient = Client::where('provider', $provider)->first();
        if ($oClient) {

            $data += [
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
            ];
            $http = new GuzzleHttpClient;

            try {
                $response = $http->request($method, $path, [
                    'form_params' => $data,
                ]);
            } catch (Exception $e) {
                return false;
            } catch (OAuthServerException $e) {
                return false;
            }
            return json_decode((string) $response->getBody(), true);
        }
        return false;
    }
}
