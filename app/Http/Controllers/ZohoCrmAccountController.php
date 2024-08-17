<?php

namespace App\Http\Controllers;

use App\Services\Token\Service;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ZohoCrmAccount\StoreRequest;
use App\Http\Requests\ZohoCrmAccount\UpdateRequest;

class ZohoCrmAccountController extends Controller
{
    public Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $accessToken = $this->service->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->get('https://www.zohoapis.eu/crm/v6/Accounts', [
                    'fields' => 'Account_Name,Phone,Website',
                    'converted' => 'true',
                ]);

        return inertia('Zoho/Account/Index', [
            'accounts' => $response['data'],
        ]);
    }

    public function create()
    {
        return inertia('Zoho/Account/Create');
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        $accessToken = $this->service->getAccessToken();
        Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->post('https://www.zohoapis.eu/crm/v6/Accounts', [
                    'data' => [
                        [
                            'Account_Name' => $validatedData['accountName'],
                            'Website' => $validatedData['website'],
                            'Phone' => $validatedData['phone'],
                        ],
                    ],
                ]);

        return redirect()->route('accounts.index')
            ->with('message', ['icon' => 'success', 'title' => 'Account created successfully']);
    }


    public function update(UpdateRequest $request, $account_id)
    {

        $validatedData = $request->validated();
        $accessToken = $this->service->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->put("https://www.zohoapis.eu/crm/v6/Accounts", [
                    'data' => [
                        [
                            'id' => $account_id,
                            'Account_Name' => $validatedData['accountName'],
                            'Phone' => $validatedData['phone'],
                            'Website' => $validatedData['website'],
                        ],
                    ],
                ]);

        return redirect()->route('accounts.index')
            ->with('message', ['icon' => 'success', 'title' => 'Account updated successfully']);
    }

    public function destroy($account_id)
    {

        $accessToken = $this->service->getAccessToken();
        Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->delete("https://www.zohoapis.eu/crm/v6/Accounts?ids={$account_id}");

        return redirect()->route('accounts.index')
            ->with('message', ['icon' => 'success', 'title' => 'Account deleted successfully']);
    }
}
