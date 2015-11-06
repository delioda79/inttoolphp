<?php

namespace spec\Integrity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdvisorSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith('John');
	}
	
    function it_is_initializable()
    {
        $this->shouldHaveType('Integrity\Advisor');
    }
    
    function it_gets_all_reviews()
    {
    	$this->getReviews()->shouldReturn([]);
    }
    
    function it_adds_a_review($review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$this->addReview($review);
    	$this->getReviews()->shouldReturn([$review]);
    }
    
    function it_orders_reviews_after_adding_a_new_one($review, $review2)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$this->addReview($review);
    	
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('-1 hour'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$this->addReview($review2);
    	
    	$this->getReviews()->shouldReturn([$review2, $review]);
    }
    
    function it_should_return_default_score()
    {
    	$this->getScore()->shouldReturn(100);
    }
}
