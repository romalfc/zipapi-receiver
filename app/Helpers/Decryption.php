<?php 

namespace App\Helpers;

class Decryption
{
    /**
     * List of encryption methods.
     * 
     * @return array
     */
    public static $ssl_methods = 
    [
        0  => 'AES-128-CBC',
        1  => 'AES-192-CBC',
        2  => 'AES-256-CBC',
        3  => 'BF-CBC',
        4  => 'CAST5-CBC',
        5  => 'DES-CBC',
        6  => 'DES-EDE-CBC',
        7  => 'DES-EDE3-CBC',
        8  => 'DESX-CBC',
        9  => 'IDEA-CBC',
        10 => 'RC2-40-CBC',
        11 => 'RC2-64-CBC',
        12 => 'RC2-CBC',
        13 => 'RC4',
        14 => 'RC4-40',
    ];

    protected static $hex_key = '1e4f5b283a2cd91a8ff95064f776d633';

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
        $hex_iv = $array['hex_iv'];
        $method_id = $array['method_id'];
        $method = self::$ssl_methods[$method_id];
        $key = hex2bin(self::$hex_key);
        $iv = hex2bin($hex_iv);
        self::decrypt_arr($structure, $method, $key, $iv);
        return ['json' => json_encode($structure, $options), 'filename' => $array['filename']];
    }

    /**
     * Decoding string that was encoded by ssl method and return decoded value
     *
     * @param  string $safe   Encrypted string  
     * @param  string $method Encryption method from $ssl_methods array 
     * @param  string $key    Secret key for decryption 
     * @param  string $iv     Initialization vector for decryption
     * @return string         Decoded string
     */
    public static function decrypt_str($safe, $method, $key, $iv)
    {
        return openssl_decrypt($safe, $method, $key, 0, $iv);
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
                $arr[self::decrypt_str($k, $method, $key, $iv)] = $d_arr;
                unset($arr[$k]);
            } else {
                $arr[$k] = self::decrypt_str($v, $method, $key, $iv);
            }
        }
        return $arr;
    }
}