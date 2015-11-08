<?php

namespace Integrity\Calculator;

use Integrity\CalculatorInterface;
use Integrity\Review;

class LongToSay implements CalculatorInterface
{
	public function getModifier(Review $review, array $reviews)
	{
		return $review->getLength() > 100 ? -0.5 : 0;
	}
}
