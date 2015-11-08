<?php

namespace spec\Integrity\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SameDeviceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Calculator\SameDevice');
    }
    
    function it_should_return_zero_when_adding_first_review($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$review->getDevice()->willReturn('LB3‐TYU');
    	$this->getModifier($review, [])->shouldReturn(0);
    }
    
    function it_should_return_zero_when_no_reviews_come_from_same_device($newReview, $review1,$review2)
    {
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$newReview->getDevice()->willReturn('LB3‐TYU');
    	
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([strtotime('now'), 'solicited', 'LB4‐TYU', 50, 5]);
    	$review1->getDevice()->willReturn('LB4‐TYU');
    	 
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('now'), 'solicited', 'LB5‐TYU', 50, 5]);
    	$review2->getDevice()->willReturn('LB5‐TYU');
    	 
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(0);
    }
    
    function it_should_return_correct_negative_value_when_new_review_come_from_existing_device($newReview, $review1,$review2)
    {
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$newReview->getDevice()->willReturn('LB3‐TYU');
    	 
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([strtotime('now'), 'solicited', 'LB4‐TYU', 50, 5]);
    	$review1->getDevice()->willReturn('LB4‐TYU');
    
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$review2->getDevice()->willReturn('LB3‐TYU');
    
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-30);
    }
}
