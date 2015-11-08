<?php

namespace Integrity\Calculator;

use Integrity\CalculatorInterface;
use Integrity\Review;

class AllStar implements CalculatorInterface
{
    public function getModifier(Review $newReview, array $reviews)
    {
    	//We don't have to subtract anything
        if ($newReview->getStars() < 5) {
        	return 0;
        }
        //The modifier is at least -2
        $result = -2;
        //There are no other reviews so we return -2
        if (count($reviews) == 0) {
        	return $result;
        }
        //Otherwise we look for the average
        if ($this->getAverage($reviews) < 3.5) {
        	$result *= 4;
        }
	
        return $result;

    }
    
    private function getAverage(array $reviews)
    {
    	$totalStars = 0;
    	foreach ($reviews as $review)
    	{
    		$totalStars += $review->getStars();
    	}
    	return (count($reviews)) ? $totalStars/count($reviews) : 0;
    }
}
