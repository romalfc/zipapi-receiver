<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table = 'users';
    
    protected $fillable = [
        'username', 'password',
    ];

    protected $hidden = [
        'password',
    ];

    public static function rules()
    {
        return [
            'username' => 'required|alpha_dash',
            'password' => 'required|min:8',
            'json'     => 'required|json'
        ];
    }

    /**
     * Authorization of user. Return success or error message.
     * 
     * @param  object  $request Request object
     * @return array            Array with success or error message
     */
    public static function authorization($request)
    {
        $user = User::where( 
                [
                    'username' => $request->get('username'),
                    'password' => $request->get('password'),
                ]
        )->first();

        if(is_null($user)){ 
            return ['error' => 'Authorization failed!'];            
        } else {                
            if(is_null($request->get('filename'))) $request->merge(['filename' => 'file.zip']);
            $json = Temp::decrypt($request->get('json'), $request->get('options'));
            History::create([
                'user_id'  => $user->id,
                'filename' => $request->get('filename'),
                'structure'=> $json,
            ]);
            return ['success' => 'JSON succesfully saved! User '.$request->get('username').'.'];            
        }
    }
}
