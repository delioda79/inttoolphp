<?php

namespace Integrity;

class Advisor
{
	protected $reviews = [];
	protected $name;
	protected $calculators = [];
	protected $score = 100;

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

        $this->calculateScore();
    }
    
    public function getScore()
    {
    	return $this->score;
    }

    public function addCalculator(Calculator $calculator)
    {
        $this->calculators[] = $calculator;
    }
    
    private function calculateScore()
    {
    	$score = $this->score;
    	foreach($this->calculators as $calculator) {
    		$score += $calculator->getModifier($this->reviews);
    	}
    	$this->score = $score;
    }
}
