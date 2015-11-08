<?php

namespace spec\Integrity\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LongToSaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Calculator\LongToSay');
    }
    
    function it_returns_zero_when_review_is_short($review)
    {
		$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	//Values around the threshold
    	$review->getLength()->willReturn(99);
    	$this->getModifier($review, [])->shouldReturn(0);

    	$review->getLength()->willReturn(100);
    	$this->getModifier($review, [])->shouldReturn(0);
    }
    
    function it_returns_correct_value_when_review_is_long($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	//Values around the threshold
    	$review->getLength()->willReturn(101);
    	$this->getModifier($review, [])->shouldReturn(-0.5);
    	 
    	$review->getLength()->willReturn(102);
    	$this->getModifier($review, [])->shouldReturn(-0.5);
    }
}
