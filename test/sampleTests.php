<?php

use PHPUnit\Framework\TestCase;

//To run the tests open your terminal and type php vendor/phpunit/phpunit/phpunit  tests/DatabaseTest.php
//similarly for other test files give the path to that file test/[name of file].php
class sampleTests extends TestCase
{
   

    public function testThatStringsMatch()
    {
        $string1 = 'testing';
        $string2 = 'testing';

        $string3 = 'Testing';

        $this->assertSame($string1, $string2);
    }


    public function testThatNumbersAddUp()
    {
        $this->assertEquals(10, 5 + 5);
    }



}