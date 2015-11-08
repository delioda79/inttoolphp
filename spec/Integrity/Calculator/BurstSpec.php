<?php

namespace spec\Integrity\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BurstSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Calculator\Burst');
    }
    
    function it_should_return_zero_when_no_previous_review($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$review->getDate()->willReturn(strtotime('now'));
    	
    	$this->getModifier($review, [])->shouldReturn(0);
    }
    
    function it_should_return_minus_fourty_when_in_minute_range($newReview, $review1, $review2)
    {
    	$startDate = strtotime('2015-11-06 10:00:00');
    	
    	$review1Date = strtotime('+10 minutes', $startDate);
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([$review1Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review1->getDate()->willReturn($review1Date);
    	
    	$review2Date = strtotime('+50 minutes', $startDate);
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([$review2Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review2->getDate()->willReturn($review2Date);
    	 
    	$newReviewDate = strtotime('+20 seconds', $review1Date);
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([$newReviewDate, 'solicited', 'LB3‐TYU', 50, 5]);
    	$newReview->getDate()->willReturn($newReviewDate);
    	
    	 
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-40);
    }

    function it_should_return_minus_twenty_when_in_hour_range($newReview, $review1, $review2)
    {
    	$startDate = strtotime('2015-11-06 10:00:00');

    	$review1Date = strtotime('+10 minutes', $startDate);
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([$review1Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review1->getDate()->willReturn($review1Date);
    	 
    	$review2Date = strtotime('+50 minutes', $startDate);
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([$review2Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review2->getDate()->willReturn($review2Date);
    
    	$newReviewDate = strtotime('+55 minutes', $startDate);
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([$newReviewDate, 'solicited', 'LB3‐TYU', 50, 5]);
    	$newReview->getDate()->willReturn($newReviewDate);
    	 
    
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-20);
    }
    
    function it_should_return_zero_when_out_of_hour_range($newReview, $review1, $review2)
    {
    	$startDate = strtotime('2015-11-06 10:00:00');
    
    	$review1Date = strtotime('+10 minutes', $startDate);
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([$review1Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review1->getDate()->willReturn($review1Date);
    
    	$review2Date = strtotime('+50 minutes', $startDate);
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([$review2Date, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review2->getDate()->willReturn($review2Date);
    
    	$newReviewDate = strtotime('+70 minutes', $startDate);
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([$newReviewDate, 'solicited', 'LB3‐TYU', 50, 5]);
    	$newReview->getDate()->willReturn($newReviewDate);
    
    
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(0);
    }
}
