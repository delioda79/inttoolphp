<?php

namespace Integrity\Calculator;

use Integrity\Review;
use Integrity\CalculatorInterface;

class SameDevice implements CalculatorInterface
{
    public function getModifier(Review $newReview, array $reviews)
    {
        foreach($reviews as $review)
        {
        	if ($review->getDevice() == $newReview->getDevice()) {
        		//Found anothe rreview from same device
        		return -30;
        	}
        }
        //First review from this device
        return 0;
    }
}
