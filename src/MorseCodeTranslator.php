<?php

/**
 * Class MorseCodeTranslator
 */

class MorseCodeTranslator
{
    private static $invalidCharacters = [
        '"', '\'', '!', '@', '#', '$', '%', '^', '&', '*',
        '(', ')', '-', '_', '+', '=', '{', '}', '[', ']',
        ':', ';', '|', '\\', '~', '`', '<', '>', '?', '/'
    ];

    private static $dictionary = [
        'A' => '.-',
        'B' => '-...',
        'C' => '-.-.',
        'D' => '-..',
        'E' => '.',
        'F' => '..-.',
        'G' => '--.',
        'H' => '....',
        'I' => '..',
        'J' => '.---',
        'K' => '-.-',
        'L' => '.-..',
        'M' => '--',
        'N' => '-.',
        'O' => '---',
        'P' => '.--.',
        'Q' => '--.-',
        'R' => '.-.',
        'S' => '...',
        'T' => '-',
        'U' => '..-',
        'V' => '...-',
        'W' => '.--',
        'X' => '-..-',
        'Y' => '-.--',
        'Z' => '--..',
        '1' => '.----',
        '2' => '..---',
        '3' => '...--',
        '4' => '....-',
        '5' => '.....',
        '6' => '-....',
        '7' => '--...',
        '8' => '---..',
        '9' => '----.',
        '0' => '-----',
        '.' => '.-.-.-',
        ',' => '--..--'
    ];

    /**
     * Get Morse code dictionary
     *
     * @return array
     */
    public function dictionary()
    {
        return static::$dictionary;
    }

    /**
     * Translates a latin string into morse code
     *
     * @param $latinString
     * @return string
     */
    public function translate($latinString)
    {
        $this->validateLatinString($latinString);

        $morseCode = '';
        $chars = str_split($latinString);
        $count = count($chars);

        /*
         * Separate letters with pipe (|)
         * Separate words with forward slash (/)
         * */

        for($i = 0; $i < $count; $i++) {

            // cache the current and next character
            $char = strtoupper($chars[$i]);
            $nextChar = !isset($chars[$i + 1]) ?: strtoupper($chars[$i + 1]);

            if(!isset(static::$dictionary[$char])) {
                $morseCode .= '/';
                continue;
            }

            $morseCode .= isset($nextChar) && ' ' === $nextChar
                ? static::$dictionary[$char]
                : static::$dictionary[$char] . '|';
        }

        return $this->cleanMorseCodeString($morseCode);
    }

    /**
     * Validates the latin string
     *
     * It matches individual latin characters in the string
     * to the equivalent latin character in the morse code dictionary
     *
     * It also matches individual latin characters in the string
     * to a dictionary of invalid characters
     *
     * If a character is invalid an exception is thrown, and we look no further
     *
     * @param $latinString
     */
    private function validateLatinString($latinString)
    {
        $chars = str_split($latinString);


        foreach ($chars as $char)
        {
            $validChars = array_merge([PHP_EOL, ' '], array_keys(static::$dictionary));

            if(in_array($char, static::$invalidCharacters) or !in_array(strtoupper($char), $validChars))
            {
                $message = sprintf('Invalid character %s detected in %s', $char, $latinString);
                throw new InvalidArgumentException($message);
            }
        }
    }

    /**
     * Clean morse code string
     *
     * @param $morseCode
     * @return string
     */
    public function cleanMorseCodeString($morseCode)
    {
        $morseCode = str_replace(PHP_EOL, '', $morseCode);
        $morseCode = rtrim($morseCode, "|/");

        return $morseCode;
    }
}
