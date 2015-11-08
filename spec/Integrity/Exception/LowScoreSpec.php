<?php

namespace spec\Integrity\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LowScoreSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith('John', 20);
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Exception\LowScore');
    }
    
    function it_should_return_message_related_to_advisor_name()
    {
    	$this->getMessage()->shouldReturn("Warning: John has a trusted review score of 20");
    }
}
