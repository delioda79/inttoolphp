<?php

namespace spec\Integrity\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PastDateReviewSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Exception\PastDateReview');
    }
    
    function it_should_return_message_related_to_advisor_name()
    {
    	$this->getMessage()->shouldReturn("Review can't be older than any of the existing ones");
    }
}
