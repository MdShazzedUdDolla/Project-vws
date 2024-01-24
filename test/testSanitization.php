<?php
      $path = dirname(__DIR__)."/API/Database/security/sanitization.php";
      echo $path;
      include_once($path);
use PHPUnit\Framework\TestCase;

//To run the tests open your terminal and type  php vendor/phpunit/phpunit/phpunit  test/testEncryptionFunctions.php >> test/logs.log
//similarly for other test files give the path to that file test/[name of file].php
class testSanitization extends TestCase
{
   

   
    public function testSanitizeString() {
        $data = '<h1>Hello World</h1>';
        $expected = 'Hello World';
        $san = new  sanitization();
        $result = $san->sanitize_data($data, 'string');
        $this->assertEquals($expected, $result);
      }
    
      public function testSanitizeInt() {
        $data = '123abc';
        $expected = 123;
        $san = new  sanitization();
        $result = $san->sanitize_data($data, 'int');
        $this->assertEquals($expected, $result);
      }
    
      public function testSanitizeEmail() {
        $data = 'test@example.com<script>alert("xss")</script>';
        $expected = 'test@example.comalert("xss")';
        $san = new  sanitization();
        $result = $san->sanitize_data($data, 'email');
        $this->assertEquals($expected, $result);
      }
    
      public function testSanitizeUrl() {
        $data = 'https://www.example.com/<script>alert("xss")</script>';
        $expected = 'https://www.example.com/alert("xss")';
        $san = new  sanitization();
        $result = $san->sanitize_data($data, 'url');
        $this->assertEquals($expected, $result);
      }
    
      public function testDefault() {
        $data = '<script>alert("xss")</script>';
        $expected = '<script>alert("xss")</script>';
        $san = new  sanitization();
        $result = $san->sanitize_data($data, 'invalid');
        $this->assertEquals($expected, $result);
      }


      public function testSanitize() {
        $sanitization = new sanitization();
    
        // test removing whitespaces
        $input = '    hello world     ';
        $expected_output = 'hello world';
        $this->assertEquals($expected_output, $sanitization->sanitize($input));
    
        // test removing backslashes
        $input = "O'Reilly \\ Publishing";
        $expected_output = "O'Reilly  Publishing";
        $this->assertEquals($expected_output, $sanitization->sanitize($input));
    
        // test replacing single quotes
        $input = "I'm a programmer";
        $expected_output = "I\\'m a programmer";
        $this->assertEquals($expected_output, $sanitization->sanitize($input));
    
        // test replacing double quotes
        $input = 'The "quick" brown fox';
        $expected_output = 'The \\"quick\\" brown fox';
        $this->assertEquals($expected_output, $sanitization->sanitize($input));
    
        // test converting special characters
        $input = '<script>alert("Hello!");</script>';
        $expected_output = '&lt;script&gt;alert(&quot;Hello!&quot;);&lt;/script&gt;';
        $this->assertEquals($expected_output, $sanitization->sanitize($input));
      }
}