<?php

namespace App;

use App\Helpers\Encryption;
use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $table = 'temp';

    protected $fillable = ['filename', 'method', 'hex_key', 'hex_iv', 'created_at', 'updated_at'];

    /**
     * Getting encrypted file structure, getting temp encrypting info 
     * from DB, clearing info in DB, decrypting and returning JSON.
     * 
     * @param  json_string $json    Encrypted JSON file structure 
     * @param  numeric     $options PHP flag for json_encode() 
     * @return json_string          Decrypted JSON file structure
     */
    public static function decrypt($json, $options)
    {
        $array = json_decode($json, true);
        $structure = $array['array'];
        $temp_id = $array['temp_id'];
    	$temp = self::find($temp_id);
        $method = $temp->method;
        $key = hex2bin($temp->hex_key);
        $iv = hex2bin($temp->hex_iv);
        self::decrypt_arr($structure, $method, $key, $iv);
        $temp->delete();
        return json_encode($structure, $options);
    }

    /**
     * Getting link on encrypted array, decrypting and returning array.
     * 
     * @param  link    &$arr   Link on encrypted associative array. 
     * @param  string  $method Encrypting method 
     * @param  string  $key    Encrypting key
     * @param  string  $iv     Encrypting initializating vector
     * @param  array   $d_keys Temp array with decrypted keys
     * @param  numeric $depth  Depth of array elements nesting
     * @return json_string     Decrypted JSON file structure
     */
    public static function decrypt_arr(&$arr, $method, $key, $iv, $d_keys = [], $depth = 0)
    {
        foreach ($arr as $k => $v) {
            if(is_array($v) && (!isset($d_keys[$depth]) || !isset($d_keys[$depth][$k]))){
                $depth =+ 1;
                $d_arr = self::decrypt_arr($v, $method, $key, $iv, $d_keys, $depth);
                $depth -= 1;
                if(isset($d_keys[$depth])) $d_keys[$depth][$k] = '';
                else {
                    $d_keys[$depth] = [];
                    $d_keys[$depth][$k] = '';
                }
                $arr[Encryption::decrypt($k, $method, $key, $iv)] = $d_arr;
                unset($arr[$k]);
            } else {
                $arr[$k] = Encryption::decrypt($v, $method, $key, $iv);
            }
        }
        return $arr;
    }
}