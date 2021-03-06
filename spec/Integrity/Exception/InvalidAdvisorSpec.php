<?php

namespace spec\Integrity\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidAdvisorSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith('John');
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Exception\InvalidAdvisor');
    }
    
    function it_should_return_message_related_to_advisor_name()
    {
    	$this->getMessage()->shouldReturn("Advisor John does not exist");
    }
}
