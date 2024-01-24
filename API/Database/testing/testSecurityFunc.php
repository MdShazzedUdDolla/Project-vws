<?php 

//phpinfo(); 
$str =  "this is a test string to encrypt";
include_once "../security/Cryptor.php";




// using the default encryption key and cipher method
$cryptor = new Cryptor('1234567890111213141516');
$crypted_token = $cryptor->encrypt($str);
echo $crypted_token;

$token = $cryptor->decrypt($crypted_token);
echo $token;

$cryptor2 = new Cryptor('1234567890111213141516');
$testenc = "01c2e23e419a59f0246b476f313ea14bY1kaHSWSWfLuIPCADIrnTOffv+LHk3DiUGVr90kBsIs=";
$token2 = $cryptor->decrypt($testenc);
echo $token2;

// using a custom key and the default cipher method
$encryption_key = 'fxEDJlUe9r4wins3';
$cryptor = new Cryptor($encryption_key);
$token = $cryptor->decrypt($crypted_token);

// using a custom key and specifying the cipher method
$encryption_key = 'd40f5fc656de8fe04d9f3574deb38093c39df4b0b40e46daad4adc466d722eda';
$cipher_method = 'aes-256-cfb';
$username = "blah";

$cryptor = new Cryptor($encryption_key, $cipher_method);
$crypted_token = $cryptor->encrypt($username);
echo "<br>LOOOOOOK<br>$crypted_token";

$token = $cryptor->decrypt($crypted_token);

echo "<br> decrypted: $token<br>";

// $index_key = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
// echo $index_key;

$encryption_key = '123456789';
$cipher_method = 'aes-256-cfb';
$cryptor = new Cryptor($encryption_key, $cipher_method);

$token = $cryptor->decrypt("2824c9569502f1f3f4b85ee346c5d8beM/M=");
echo "HOOOOOOOOOOOOOOOOO".$token;
?>