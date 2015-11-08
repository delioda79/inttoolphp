<?php

namespace Integrity;

use Integrity\Exception\LowScore;
use Integrity\Exception\ExtraLowScore;
use Integrity\Exception\PastDateReview;
class Advisor
{
	const MAX_SCORE = 100;
	const STATUS_ACTIVE = 2;
	const STATUS_WARNED = 1;
	const STATUS_INACTIVE = 0;
	
	protected $reviews = [];
	protected $name;
	protected $calculators = [];
	protected $score = Advisor::MAX_SCORE;
	
	protected $status = Advisor::STATUS_ACTIVE;

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
    
    public function getName()
    {
    	return $this->name;
    }
    
    public function getStatus()
    {
    	return $this->status;
    }
    
    /**
     * It calculates the score of the
     * advisor. It accepts a Review object
     * as new review to possibly trigger
     * a modifier in the existing score.
     * It makes use of the existing reviews
     * for comparison. This method also takes
     * care of throwing exceptions to notify
     * any change in state to the advisor.
     * 
     * @param Integrity\Review $review
     * @throws ExtraLowScore
     * @throws LowScore
     */
    private function calculateScore($review)
    {
    	$score = $this->score;
    	foreach($this->calculators as $calculator) {
    		$score += $calculator->getModifier($review, $this->reviews);
    	}
    	$this->score = $score < $this::MAX_SCORE ? $score : $this::MAX_SCORE;
    	
    	if ($this->score < 50 && $this->status > Advisor::STATUS_INACTIVE) {
    		$this->status = Advisor::STATUS_INACTIVE;
    		throw new ExtraLowScore($this->getName());
    	} else if ($this->score < 70 && $this->status > Advisor::STATUS_WARNED) {
    		$this->status = Advisor::STATUS_WARNED;
    		throw new LowScore($this->getName(), $this->score);
    	}
    }
    
    /**
     * It makes sure that no review is inserted
     * with date preceding any existing review.
     * It is supposed that reviews come in
     * ascending time order as score calculation
     * depends on it.
     * 
     * @param Review $review
     * @throws PastDateReview
     */
    private function enforceTime(Review $review)
    {
    	$reviewsCount = count($this->reviews);
    	if ( $reviewsCount > 0) {
    		$lastDate = $this->reviews[$reviewsCount-1]->getDate();

    		if ($lastDate > $review->getDate()) {
    			throw new PastDateReview();
    		}    	
    	}
    }
}
