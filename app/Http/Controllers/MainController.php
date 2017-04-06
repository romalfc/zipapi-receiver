<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function json(Request $request)
    {
        $request->merge(['json' => json_encode($request->get('json'), $request->get('options'))]);

        $this->validate($request, User::rules());
        $response = User::authorization($request);
        return json_encode($response);
    }

    //
}
