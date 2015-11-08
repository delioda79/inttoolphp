<?php

namespace spec\Integrity\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Exception\InvalidData');
    }
    
    function it_should_return_message_related_to_advisor_name()
    {
    	$this->getMessage()->shouldReturn("Could not read review summary data");
    }
}
