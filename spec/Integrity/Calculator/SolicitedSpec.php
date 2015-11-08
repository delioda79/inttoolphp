<?php

namespace spec\Integrity\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SolicitedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Calculator\Solicited');
    }
    
    function it_returns_zero_when_review_is_unsolicited($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'unsolicited', 'LB3‐TYU', 50, 5]);
    	$review->getType()->willReturn('unsolicited');
    	$this->getModifier($review, [])->shouldReturn(0);
    }
    
    function it_returns_three_when_review_is_solicited($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	//Values around the threshold
    	$review->getType()->willReturn('solicited');
    	$this->getModifier($review, [])->shouldReturn(3);
    }
}
