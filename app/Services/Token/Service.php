<?php

namespace App\Services\Token;

use App\Models\AuthToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Service
{
    public function getAccessToken()
    {

        $storedToken = AuthToken::first();

        if ($storedToken['expires_at'] < Carbon::now()) {
            $newToken = $this->refreshAccessToken($storedToken['refresh_token']);
            $this->storeToken($newToken, $storedToken['refresh_token']);

            return $newToken['access_token'];
        } else {
            return $storedToken['access_token'];
        }

    }

    private function refreshAccessToken($refreshToken)
    {

        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');

        $response = Http::post("https://accounts.zoho.eu/oauth/v2/token?refresh_token={$refreshToken}&client_id={$clientId}&client_secret={$clientSecret}&grant_type=refresh_token"
        );

        return $response->json();
    }

    private function storeToken($tokenData, $refreshToken)
    {
        AuthToken::updateOrCreate(
            ['refresh_token' => $refreshToken],
            [
                'access_token' => $tokenData['access_token'],
                'expires_at' => Carbon::now()->addSeconds($tokenData['expires_in']),
            ]
        );
    }
}
