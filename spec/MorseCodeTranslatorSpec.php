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

    function it_should_have_an_index_smaller_than_characters_count()
    {
        $index = 4;
        $chars = str_split(static::$hello);
        $this->indexInBounds($chars, $index)->shouldEqual(true);
    }

    function it_should_not_have_an_index_bigger_than_characters_count()
    {
        $index = 6;
        $chars = str_split(static::$hello);
        $this->indexInBounds($chars, $index)->shouldEqual(false);
    }

    function it_should_have_character_in_dictionary()
    {
        $char = 'A';
        $this->isInDictionary($char)->shouldEqual(true);
    }

    function it_should_not_have_character_in_dictionary()
    {
        $char = ' ';
        $this->isInDictionary($char)->shouldEqual(false);
    }

    function it_should_add_pipe_character_to_morse_code_string()
    {
        $chars = str_split(static::$hello);
        $this->canAddPipeCharacter($chars, 0)->shouldEqual(true);
    }

    function it_should_not_add_pipe_character_to_morse_code_string()
    {
        $chars = str_split(static::$iAmInTrouble);
        $this->canAddPipeCharacter($chars, 0)->shouldEqual(false);
    }

    function it_should_validate_a_latin_string_of_characters()
    {
        $this->shouldNotThrow('InvalidArgumentException')->duringValidateLatinString(static::$hello);
    }

    function it_should_take_exception_to_translate_invalid_characters()
    {
        foreach(static::$invalidCharacters as $invalidCharacter)
        {
            $this->shouldThrow('InvalidArgumentException')->duringValidateLatinString("HEL{$invalidCharacter}LO");
        }
    }

    function it_should_gracefully_handle_translation_of_lowercase_latin_characters()
    {
        $this->shouldNotThrow('InvalidArgumentException')->duringTranslate('hello');
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
