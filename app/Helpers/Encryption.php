<?php 

namespace App\Helpers;

class Encryption
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

    /**
     * Encoding string with current ssl method and return encoded value
     * 
     * @param  string $string Encrypted string  
     * @param  string $method Encryption method from $ssl_methods array 
     * @param  string $key    Secret key for encryption 
     * @param  string $iv     Initialization vector for encryption
     * @return string         Encoded string
     */
    public static function encrypt($string, $method, $key, $iv)
    {
        return openssl_encrypt($string, $method, $key, 0, $iv);
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
    public static function decrypt($safe, $method, $key, $iv)
    {
        return openssl_decrypt($safe, $method, $key, 0, $iv);
    }
}