<?php

namespace spec\Integrity\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExtraLowScoreSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith('John');
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Exception\ExtraLowScore');
    }
    
    function it_should_return_message_related_to_advisor_name()
    {
    	$this->getMessage()->shouldReturn("Alert: John has been de‐activated due to a low trusted review score");
    }
}
