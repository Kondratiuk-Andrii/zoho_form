<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Token\Service;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ZohoCrmDeal\StoreRequest;
use App\Http\Requests\ZohoCrmDeal\UpdateRequest;

class ZohoCrmDealController extends Controller
{
    public Service $service;

    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $accessToken = $this->service->getAccessToken();

        $responseDeals = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->get('https://www.zohoapis.eu/crm/v6/Deals', [
                    'fields' => 'Deal_Name,Stage,Account_Name',
                    'converted' => 'true',
                ]);

        $responseAccounts = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->get('https://www.zohoapis.eu/crm/v6/Accounts', [
                    'fields' => 'Account_Name,Phone,Website',
                    'converted' => 'true',
                ]);

        return inertia('Zoho/Deal/Index', [
            'deals' => $responseDeals['data'],
            'accounts' => $responseAccounts['data'],
        ]);
    }

    public function create()
    {
        $accessToken = $this->service->getAccessToken();

        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->get('https://www.zohoapis.eu/crm/v6/Accounts', [
                    'fields' => 'Account_Name,Phone,Website',
                    'converted' => 'true',
                ]);
        return inertia('Zoho/Deal/Create', [
            'accounts' => $response['data'],
        ]);
    }

    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();
        $accessToken = $this->service->getAccessToken();


        Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->post('https://www.zohoapis.eu/crm/v6/Deals', [
                    'data' => [
                        [
                            'Deal_Name' => $validatedData['dealName'],
                            'Stage' => $validatedData['stage'],
                            'Account_Name' => $validatedData['accountId'],
                        ],
                    ],
                ]);

        return redirect()->route('deals.index')
            ->with('message', ['icon' => 'success', 'title' => 'Deal created successfully']);
    }

    public function update(UpdateRequest $request, $deal_id)
    {
        $validatedData = $request->validated();
        $accessToken = $this->service->getAccessToken();
        $response = Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->put("https://www.zohoapis.eu/crm/v6/Deals", [
                    'data' => [
                        [
                            'id' => $deal_id,
                            'Deal_Name' => $validatedData['dealName'],
                            'Stage' => $validatedData['stage'],
                            'Account_Name' => $validatedData['accountId'],
                        ],
                    ],
                ]);
        return redirect()->route('deals.index')
            ->with('message', ['icon' => 'success', 'title' => 'Deal updated successfully']);
    }

    public function destroy($deal_id)
    {

        $accessToken = $this->service->getAccessToken();
        Http::withHeaders([
            'Authorization' => "Zoho-oauthtoken {$accessToken}",
        ])->delete("https://www.zohoapis.eu/crm/v6/Deals?ids={$deal_id}");

        return redirect()->route('deals.index')
            ->with('message', ['icon' => 'success', 'title' => 'Account deleted successfully']);
    }
}
