<?php

namespace spec;

use MorseCodeObfuscator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MorseCodeObfuscatorSpec extends ObjectBehavior
{
    private static $helloMorse = '....|.|.-..|.-..|---';
    private static $helloMorseObfuscated = '4|1|1A2|1A2|C';

    function it_is_initializable()
    {
        $this->shouldHaveType(MorseCodeObfuscator::class);
    }

    function it_should_not_allow_obfuscating_of_invalid_argument_type()
    {
        $this->shouldThrow('InvalidArgumentException')->duringObfuscate(5);
        $this->shouldThrow('InvalidArgumentException')->duringObfuscate('');
        $this->shouldThrow('InvalidArgumentException')->duringObfuscate([]);
        $this->shouldThrow('InvalidArgumentException')->duringObfuscate(null);
        $this->shouldThrow('InvalidArgumentException')->duringObfuscate(true);
    }

    function it_should_return_obfuscated_morse_code()
    {
        $this->obfuscate(static::$helloMorse)->shouldBe(static::$helloMorseObfuscated);
    }
}
