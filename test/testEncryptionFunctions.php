<?php
      $path = dirname(__DIR__)."/API/Database/security/Cryptor.php";
      echo $path;
      include_once($path);
use PHPUnit\Framework\TestCase;

//To run the tests open your terminal and type  php vendor/phpunit/phpunit/phpunit  test/testEncryptionFunctions.php >> test/logs.log
//similarly for other test files give the path to that file test/[name of file].php
class testEncryptionFunctions extends TestCase
{
   


    function testWithRandKey(){
        // using a custom key and specifying the cipher method

        $encryption_key = '123456789';
        $cipher_method = 'aes-256-cfb';
        $username = "blah";

        $cryptor = new Cryptor($encryption_key, $cipher_method);
        $crypted_token = $cryptor->encrypt($username);
 

        $token = $cryptor->decrypt($crypted_token);
        $this->assertSame($username, $token);
    }


    function testWithDefaultCipherMethod(){
        // using a custom key and the default cipher method
        $encryption_key = 'fxEDJlUe9r4wins3';
        $cryptor = new Cryptor($encryption_key);
        $str = "this is the plain text.";
        $crypted_token = $cryptor->encrypt($str);
        $token = $cryptor->decrypt($crypted_token);

        $this->assertSame($str, $token);
    }


    
    function testWithDefault(){
        // using a custom key and the default cipher method
       
        $cryptor = new Cryptor();
        $str = "this is the plain text.";
        $crypted_token = $cryptor->encrypt($str);
        $token = $cryptor->decrypt($crypted_token);

        $this->assertSame($str, $token);
    }

}