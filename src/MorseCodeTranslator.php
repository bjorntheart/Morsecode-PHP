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

            // cache the current character
            $char = strtoupper($chars[$i]);

            if(!isset(static::$dictionary[$char])) {
                $morseCode .= '/';
                continue;
            }

            $morseCode .= static::$dictionary[$char];
            if ($this->canAddPipeCharacter($chars, $i)) {
                $morseCode .= '|';
            }
        }

        return $this->cleanMorseCodeString($morseCode);
    }

    /**
     * Check if we can add the letter separator |
     *
     * @param $chars
     * @param $index
     * @return bool
     */
    public function canAddPipeCharacter($chars, $index)
    {
        $nextChar = !isset($chars[$index + 1]) ?: strtoupper($chars[$index + 1]);
        return $this->indexInBounds($chars, $index) && $this->isInDictionary($nextChar);
    }

    /**
     * Check if the current index is smaller than the character count
     *
     * Useful if we want to inspect the next character in the array and not
     * error out on wrong index offset
     *
     * @param $chars
     * @param $index
     * @return bool
     */
    public function indexInBounds($chars, $index)
    {
        return $index < count($chars);
    }

    /**
     * Check if a character is in the dictionary
     * @param $char
     * @return bool
     */
    public function isInDictionary($char)
    {
        return isset(static::$dictionary[$char]);
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
    public function validateLatinString($latinString)
    {
        $chars = str_split($latinString);
        $validChars = array_merge([PHP_EOL, ' '], array_keys(static::$dictionary));

        foreach($chars as $char)
        {
            if(!in_array(strtoupper($char), $validChars, true)) {
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
