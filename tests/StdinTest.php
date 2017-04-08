<?php

use PHPUnit_Framework_TestCase as TestCase;

include_once dirname(__FILE__).'/../src/stdinFunctions.php';

/**
 * Created by PhpStorm.
 * User: bjorn
 * Date: 2017/04/08
 * Time: 17:35
 */
class StdinTest extends TestCase
{
    public function test_translate_and_obfuscate_with_single_input()
    {
        $result = translateAndObfuscate(['HELLO']);
        $this->assertEquals('4|1|1A2|1A2|C'.PHP_EOL, $result);
    }

    public function test_translate_and_obfuscate_with_multiple_inputs()
    {
        $result = translateAndObfuscate(['HELLO', 'I AM IN TROUBLE']);
        $this->assertEquals('4|1|1A2|1A2|C'.PHP_EOL.'2/1A|B/2|A1/A|1A1|C|2A|A3|1A2|1'.PHP_EOL, $result);
    }

    public function test_translate_and_obfuscate_file_input()
    {
        $result = translateAndObfuscateFileInput('src/input.txt');
        $this->assertEquals('4|1|1A2|1A2|C'.PHP_EOL.'2/1A|B/2|A1/A|1A1|C|2A|A3|1A2|1'.PHP_EOL, $result);
    }

    public function test_translate_and_obfuscate_with_file_input()
    {
        $testFile = dirname(__FILE__).'/test-input-file.txt';
        $this->assertFileExists($testFile);

        $this->assertStringEqualsFile($testFile, 'HELLO'.PHP_EOL.'I AM IN TROUBLE');

        $result = translateAndObfuscateFileInput($testFile);
        $this->assertEquals('4|1|1A2|1A2|C'.PHP_EOL.'2/1A|B/2|A1/A|1A1|C|2A|A3|1A2|1'.PHP_EOL, $result);
    }

}