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
    
    function it_adds_reviews_with_increasing_time($review1, $review2)
    {
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([strtotime('-1 hour'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$this->addReview($review1);
    	
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	$this->addReview($review2);
    	
    	$this->getReviews()->shouldReturn([$review1, $review2]);
    }
    
    function it_should_prevent_insertion_of_older_review($review1, $review2)
    {
    	$now = strtotime('now');
    	$review1->beADoubleOf('Integrity\Review');
    	$review1->beConstructedWith([$now, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review1->getDate()->willReturn($now);
    	$this->addReview($review1);

    	$oneHrAgo = strtotime('-1 hour');
    	$review2->beADoubleOf('Integrity\Review');
    	$review2->beConstructedWith([$oneHrAgo, 'solicited', 'LB3‐TYU', 50, 5]);
    	$review2->getDate()->willReturn($oneHrAgo);
    	$this->shouldThrow('\Exception')->duringAddReview($review2);
    }

    function it_should_return_default_score()
    {
    	$this->getScore()->shouldReturn(100);
    }
    
    function it_should_set_calculators_and_return_correct_score($calculator1, $calculator2, $review)
    {
    	$review->beADoubleOf('Integrity\Review');
    	$review->beConstructedWith([strtotime('now'), 'solicited', 'LB3‐TYU', 50, 5]);
    	 
    	$calculator1->beADoubleOf('Integrity\CalculatorInterface');
    	$calculator1->getModifier($review, [])->willReturn(-1);
    	$this->addCalculator($calculator1);

    	$calculator2->beADoubleOf('Integrity\CalculatorInterface');
    	$calculator2->getModifier($review, [])->willReturn(-2);
    	$this->addCalculator($calculator2);
 
    	$this->addReview($review);

    	$this->getScore()->shouldReturn(97);
    }
    
    function it_should_return_advisor_name()
    {
    	$this->getName()->shouldReturn('John');
    }
}
