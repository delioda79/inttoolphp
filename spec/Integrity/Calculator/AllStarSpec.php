<?php

namespace spec\Integrity\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AllStarSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Calculator\AllStar');
    }
    
    function it_should_return_zero_when_review_has_less_than_maximum_stars($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 4]);
    	$review->getStars()->willReturn(4);
    	$this->getModifier($review, [])->shouldReturn(0);
    }
    
    function it_should_return_minus_too_when_review_has_five_stars($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$review->getStars()->willReturn(5);
    	$this->getModifier($review, [])->shouldReturn(-2);
    }
    
    function it_should_return_minus_two_when_review_has_five_stars_and_average_is_high($newReview, $review1,$review2, $review3)
    {
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 4]);
    	$newReview->getStars()->willReturn(5);
    	 
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([strtotime('now'), 'solicited', 'LB4‐TYU', 50, 3]);
    	$review1->getStars()->willReturn(3);
    
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('now'), 'solicited', 'LB5‐TYU', 50, 5]);
    	$review2->getStars()->willReturn(4);
    	//Average is now 3.5 which is the threshold
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-2);
    	
    	$review3->beADoubleOf('Integrity\Review');
    	$review3->beConstructedWith([strtotime('now'), 'solicited', 'LB5‐TYU', 50, 5]);
    	$review3->getStars()->willReturn(4);
    	//Average is now more than 3.5 which is the threshold
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-2);
    }
    
	function it_should_return_minus_eight_when_review_has_five_stars_and_average_is_low($newReview, $review1, $review2, $review3)
    {
    	$newReview->beADoubleOf('Integrity\Review');
    	$newReview->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 4]);
    	$newReview->getStars()->willReturn(5);
    	 
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([strtotime('now'), 'solicited', 'LB4‐TYU', 50, 3]);
    	$review1->getStars()->willReturn(3);
    
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('now'), 'solicited', 'LB5‐TYU', 50, 5]);
    	$review2->getStars()->willReturn(3);
    	//Average is now more than 3 which is less than the threshold
    	$this->getModifier($newReview, [$review1, $review2])->shouldReturn(-8);
    }
}
