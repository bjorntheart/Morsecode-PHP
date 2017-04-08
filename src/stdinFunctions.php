<?php

/**
 * Parse the given inputs from STDIN
 * - translate the given inputs to morse code
 * - obfuscate the morse code
 *
 * @param $inputs
 * @return string
 */
function translateAndObfuscate($inputs)
{

    $output = '';
    $morseCodeTranslator = new MorseCodeTranslator();
    $morseCodeObfuscator = new MorseCodeObfuscator();

    try
    {
        foreach($inputs as $input)
        {
            $moreseCode = $morseCodeTranslator->translate($input);
            $obfuscatedMorseCode = $morseCodeObfuscator->obfuscate($moreseCode);
            $output .= $obfuscatedMorseCode.PHP_EOL;
        }
    }
    catch(InvalidArgumentException $e)
    {
        return sprintf("\n%s\n\n", $e->getMessage());
    }

    return $output;
}

/**
 * Handle file input from STDIN and read the file contents into an array
 *
 * @param $filePath
 * @return string
 */
function translateAndObfuscateFileInput($filePath)
{
    try
    {
        $lines = file($filePath);

        return translateAndObfuscate($lines);
    }
    catch(Exception $e)
    {
        return sprintf("\n%s\n\n", $e->getMessage());
    }
}