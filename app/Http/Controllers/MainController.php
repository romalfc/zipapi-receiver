<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Getting request from Sender API, response validating, checking user authorization,
     * decrypting of file structure, saving to DB and sending response in JSON 
     * with success or failure message
     * 
     * @param  object $request Request object 
     * @return json_string
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
