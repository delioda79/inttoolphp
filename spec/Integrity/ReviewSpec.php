<?php

namespace spec\Integrity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReviewSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
    	$this->beConstructedWith(strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5);
        $this->shouldHaveType('Integrity\Review');
    }
}
