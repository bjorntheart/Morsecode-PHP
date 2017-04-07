<?php

require_once(dirname ( __FILE__ ).'/../vendor/autoload.php');

/**
 * Handle prompts from STDIN
 * @param $prompt
 * @return string
 */
function prompt($prompt)
{
    while(!isset($input))
    {
        echo $prompt;
        $input = trim(fgets(STDIN));

        return $input;
    }
}

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

/**
 * Print the translated and obfuscated text to the console
 *
 * @param $output
 */
function printResult($output)
{
    if(!$output) {
        echo PHP_EOL."No output to print!".PHP_EOL;

        return;
    }

    echo sprintf("\nObfuscated morse code\n\n%s\n", $output);
}

$prompt = <<<EOT

What would you like to do?

    1) Enter text input
    2) Enter file path
    
Answer: 
EOT;

$answer = prompt($prompt);

if($answer) {

    switch ($answer) {
        case 1:

            $text = prompt("Enter text input to translate and obfuscate: ");

            if($text)
            {
                $inputs[] = $text;

                $continue = prompt("Do you wish to enter more text? (yes, YES, Y, y):");

                while($continue && in_array($continue, ['yes', 'YES', 'Y', 'y']))
                {
                    $text = prompt("Enter text input to translate and obfuscate: ");

                    if ($text)
                    {
                        $inputs[] = $text;
                    }

                    $continue = prompt("Do you wish to enter more text? ");
                }

                $output = translateAndObfuscate($inputs);

                printResult($output);
            }
            break;
        case 2:

            $filePath = prompt("File path(src/input.txt): ");

            if($filePath && is_file($filePath))
            {
                $output = translateAndObfuscateFileInput(strtolower($filePath));

                printResult($output);
            }
            else
            {
                echo "File does not exists!".PHP_EOL;
            }
            break;
        default: break;
    }
    exit();
}