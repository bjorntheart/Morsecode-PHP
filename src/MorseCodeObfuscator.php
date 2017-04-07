<?php

/**
 * Class MorseCodeObfuscator
 */
class MorseCodeObfuscator
{
    /**
     * Obfuscate morse code
     *
     * @param $morseCode
     * @return mixed
     */
    public function obfuscate($morseCode)
    {
        if (!$morseCode or 'string' !== gettype($morseCode)) throw new InvalidArgumentException;

        $patterns = [
            '/\.{5}/',
            '/\.{4}/',
            '/\.{3}/',
            '/\.{2}/',
            '/\./',
            '/\-{3}/',
            '/\-{2}/',
            '/\-/',
        ];

        return preg_replace($patterns, [5, 4, 3, 2, 1, 'C', 'B', 'A'], $morseCode);
    }
}
