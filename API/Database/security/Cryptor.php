

<?php
//for data at rest encryption set up on deployment server
//https://webdock.io/en/docs/how-guides/security-guides/how-to-enable-encryption-mariadb
//https://severalnines.com/blog/exploring-different-ways-encrypt-your-mariadb-data/
//https://jdc-cunningham.medium.com/adding-server-side-encryption-to-your-mysql-database-with-php-defuse-553a26972d3c
//https://webdock.io/en/docs/how-guides/security-guides/how-to-enable-encryption-mariadb
//https://mariadb.com/kb/en/innodb-encryption-overview/
//https://severalnines.com/blog/exploring-different-ways-encrypt-your-mariadb-data/
//https://softwareengineering.stackexchange.com/questions/177788/should-i-encrypt-data-in-database


//this is a more extensive librabry https://symfony.com/doc/current/security.html suggested to implement
class Cryptor
{

  protected $method = 'aes-128-ctr'; // default cipher method if none supplied
  private $key;

  protected function iv_bytes()
  {
    return openssl_cipher_iv_length($this->method);
  }

  public function __construct($key = FALSE, $method = FALSE)
  {
    if(!$key) {
      $key = php_uname(); // default encryption key if none supplied
    }
    if(ctype_print($key)) {
      // convert ASCII keys to binary format
      $this->key = openssl_digest($key, 'SHA256', TRUE);
    } else {
      $this->key = $key;
    }
    if($method) {
      if(in_array(strtolower($method), openssl_get_cipher_methods())) {
        $this->method = $method;
      } else {
        die(__METHOD__ . ": unrecognised cipher method: {$method}");
      }
    }
  }

  public function encrypt($data)
  {
    $iv = openssl_random_pseudo_bytes($this->iv_bytes());
    return bin2hex($iv) . openssl_encrypt($data, $this->method, $this->key, 0, $iv);
  }

  // decrypt encrypted string
  public function decrypt($data)
  {
    $iv_strlen = 2  * $this->iv_bytes();
    if(preg_match("/^(.{" . $iv_strlen . "})(.+)$/", $data, $regs)) {
      list(, $iv, $crypted_string) = $regs;
      if(ctype_xdigit($iv) && (strlen($iv) % 2 == 0)) {
        return openssl_decrypt($crypted_string, $this->method, $this->key, 0, hex2bin($iv));
      }
    }
    return FALSE; // failed to decrypt
  }

}




?>