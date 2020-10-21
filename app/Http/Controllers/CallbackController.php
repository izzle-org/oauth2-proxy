<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\Redirector;

class CallbackController extends Controller
{
    /***
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws ValidationException
     */
    public function callback(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'state' => 'required|min:40'
        ]);

        $params = [
            'state' => $request->get('state'),
            'code' => $request->get('code')
        ];

        return redirect($request->session()->get('redirect_uri') . '?' . http_build_query($params));
    }
}
