<?php
namespace App\Http\Controllers;

use App\User;
use App\Temp;
use App\History;
use App\Helpers\Decryption;
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
        $this->validate($request, User::rules()); //validation
        $user_id = $request->user_id;
        $json = Decryption::decrypt($request->get('json'), $request->get('options'));
        History::create([
            'user_id'  => $user_id,
            'filename' => $json['filename'],
            'structure'=> $json['json'],
        ]);
        return response()->json(['success' => 'JSON succesfully saved! User '.$request->get('username').'.']);
    }

    //
}
