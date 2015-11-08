<?php

namespace Integrity;

use Integrity\Exception\LowScore;
use Integrity\Exception\ExtraLowScore;
class Advisor
{
	const MAX_SCORE = 100;
	
	protected $reviews = [];
	protected $name;
	protected $calculators = [];
	protected $score = Advisor::MAX_SCORE;

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
    	$this->enforceTime($review);
    	$this->calculateScore($review);
        $this->reviews[] = $review;
    }
    
    public function getScore()
    {
    	return $this->score;
    }

    public function addCalculator(CalculatorInterface $calculator)
    {
        $this->calculators[] = $calculator;
    }
    
    private function calculateScore($review)
    {
    	$score = $this->score;
    	foreach($this->calculators as $calculator) {
    		$score += $calculator->getModifier($review, $this->reviews);
    	}
    	$this->score = $score < $this::MAX_SCORE ? $score : $this::MAX_SCORE;
    	
    	if ($this->score < 50) {
    		throw new ExtraLowScore($this->getName());
    	} else if ($this->score < 70) {
    		throw new LowScore($this->getName(), $this->score);
    	}
    }
    
    private function enforceTime(Review $review)
    {
    	$reviewsCount = count($this->reviews);
    	if ( $reviewsCount > 0) {
    		$lastDate = $this->reviews[$reviewsCount-1]->getDate();

    		if ($lastDate > $review->getDate()) {
    			throw new \Exception("Review can't be older than any of the existing ones");
    		}    	
    	}
    }

    public function getName()
    {
        return $this->name;
    }
}
