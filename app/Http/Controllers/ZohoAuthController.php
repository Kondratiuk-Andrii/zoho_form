<?php

namespace App\Http\Controllers;

use App\Models\AuthToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZohoAuthController extends Controller
{
    public function redirectToZoho()
    {

        $clientId = env('ZOHO_CLIENT_ID');
        $redirectUri = env('ZOHO_REDIRECT_URI');
        $scope = 'ZohoCRM.modules.ALL';
        $responseType = 'code';

        $url = "https://accounts.zoho.com/oauth/v2/auth?scope={$scope}&client_id={$clientId}&response_type={$responseType}&access_type=offline&redirect_uri={$redirectUri}";

        return redirect()->away($url);

    }

    public function handleZohoCallback(Request $request)
    {
        $code = $request->query('code');

        $clientId = env('ZOHO_CLIENT_ID');
        $clientSecret = env('ZOHO_CLIENT_SECRET');
        $redirectUri = env('ZOHO_REDIRECT_URI');
        $grant_type = 'authorization_code';

        $response = Http::asForm()->post('https://accounts.zoho.eu/oauth/v2/token', [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => $grant_type,
        ]);

        $response = $response->json();

        AuthToken::create([
            'access_token' => $response['access_token'],
            'refresh_token' => $response['refresh_token'],
            'expires_at' => Carbon::now()->addSeconds($response['expires_in']),
        ]);

        return redirect()->route('dashboard')
            ->with('message', ['icon' => 'success', 'title' => 'Zoho connection successful']);
    }

    public function handleLogout()
    {
        AuthToken::truncate();

        return redirect()->route('dashboard')
            ->with('message', ['icon' => 'success', 'title' => 'You logged out successfully']);
    }
}
