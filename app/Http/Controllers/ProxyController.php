<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\Redirector;

class ProxyController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function redirect(Request $request)
    {
        $this->validate($request, [
            'redirect_uri' => 'required|url',
            'state' => 'required|min:40'
        ]);

        $request->session()->put('redirect_uri', $request->get('redirect_uri'));

        $params = [
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'redirect_uri' => env('URL_CALLBACK'),
            'response_type' => $request->get('response_type', 'code'),
            'scope' => $request->get('scope', 'profile'),
            'state' => $request->get('state')
        ];

        return redirect(env('URL_AUTHORIZE') . '?' . http_build_query($params));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws GuzzleException
     * @throws ValidationException
     */
    public function token(Request $request): JsonResponse
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $params = [
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'redirect_uri' => env('URL_CALLBACK'),
            'grant_type' => 'authorization_code',
            'code' => $request->get('code')
        ];

        $request = (new Client())->request('POST', env('URL_ACCESS_TOKEN'), [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => $params
        ]);

        return response()->json((string) $request->getBody());
    }
}
