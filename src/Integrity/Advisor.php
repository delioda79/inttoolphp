<?php

namespace Integrity;

class Advisor
{
	protected $reviews = [];
	protected $name;
	
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getReviews()
    {
        return $this->reviews;
    }

    public function addReview(Review $review)
    {
        $this->reviews[] = $review;
        /**
         * We are modifying the original array,
         * cause of a PHP bug in versions >= 5.2
         * usort will throw an error when using
         * debugging functions like in phpspecs.
         */
        @usort($this->reviews, function($a, $b) {
        	if ($a->getDate() == $b->getDate()) {
        		return 0;
        	} else {
        		return ($a->getDate() < $b->getDate()) ? -1 : 1;
        	}
        });
    }
    
    public function getScore()
    {
    	$score = 100;
    	return $score;
    }
}
