<?php

include_once(dirname ( __FILE__ ).'/../vendor/autoload.php');
include_once(dirname ( __FILE__ ).'/stdinFunctions.php');

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