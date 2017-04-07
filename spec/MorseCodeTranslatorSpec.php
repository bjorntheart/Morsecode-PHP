<?php

namespace spec;

use MorseCodeTranslator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MorseCodeTranslatorSpec extends ObjectBehavior
{
    private static $invalidCharacters = [
        '"', '\'', '!', '@', '#', '$', '%', '^', '&', '*',
        '(', ')', '-', '_', '+', '=', '{', '}', '[', ']',
        ':', ';', '|', '\\', '~', '`', '<', '>', '?', '/'
    ];
    private static $hello = 'HELLO';
    private static $iAmInTrouble = 'I AM IN TROUBLE';
    private static $helloMorse = '....|.|.-..|.-..|---';
    private static $iAmInTroubleMorse = '../.-|--/..|-./-|.-.|---|..-|-...|.-..|.';

    function it_is_initializable()
    {
        $this->shouldHaveType(MorseCodeTranslator::class);
    }

    function it_should_have_a_morse_code_dictionary_array()
    {
        $this->dictionary()->shouldBeArray();
        $this->dictionary()->shouldHaveCount(38);
    }

    function it_should_handle_any_invalid_latin_character_input()
    {
        foreach(static::$invalidCharacters as $invalidCharacter)
        {
            $this->shouldThrow('InvalidArgumentException')->duringTranslate("HEL{$invalidCharacter}LO");
        }
    }

    function it_should_allow_for_translation_of_uppercase_latin_characters()
    {
        $this->shouldNotThrow('InvalidArgumentException')->duringTranslate('HELLO');
    }

    function it_should_not_have_new_line_characters_in_the_morse_code()
    {
        $this->translate(static::$hello.PHP_EOL)->shouldBe(static::$helloMorse);
    }

    function it_should_not_have_trailing_pipe_character_in_the_morse_code()
    {
        $this->translate(static::$hello)->shouldNotBe(static::$helloMorse.'|');
        $this->translate(static::$iAmInTrouble)->shouldNotBe(static::$iAmInTroubleMorse.'|');

    }
    function it_should_not_have_trailing_forward_slash_character_in_the_morse_code()
    {
        $this->translate(static::$hello)->shouldNotBe(static::$helloMorse.'/');
        $this->translate(static::$iAmInTrouble)->shouldNotBe(static::$iAmInTroubleMorse.'/');
    }

    function it_should_not_have_trailing_pipe_or_forward_slash_character_in_the_morse_code()
    {
        $this->translate(static::$hello)->shouldNotBe(static::$helloMorse.'|/');
        $this->translate(static::$iAmInTrouble)->shouldNotBe(static::$iAmInTroubleMorse.'|/');
    }

    function it_should_translate_a_latin_character_string_to_morse_code()
    {
        $this->translate(static::$hello)->shouldBe(static::$helloMorse);
        $this->translate(static::$iAmInTrouble)->shouldBe(static::$iAmInTroubleMorse);
    }

}
