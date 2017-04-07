<?php

namespace spec;

use ArrayHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayHelperSpec extends ObjectBehavior
{
    function it_is_initializable() {
        $this->shouldHaveType(ArrayHelper::class);
    }

    function it_should_not_allow_flattening_of_invalid_argument_type() {
        $this->shouldThrow('InvalidArgumentException')->duringFlatten(5);
        $this->shouldThrow('InvalidArgumentException')->duringFlatten('');
        $this->shouldThrow('InvalidArgumentException')->duringFlatten([]);
        $this->shouldThrow('InvalidArgumentException')->duringFlatten(null);
        $this->shouldThrow('InvalidArgumentException')->duringFlatten(true);
    }

    function it_should_return_a_flattened_array() {
        $this->flatten([1, [2, [3]], 4])->shouldBe([1, 2, 3, 4]);
    }
}
