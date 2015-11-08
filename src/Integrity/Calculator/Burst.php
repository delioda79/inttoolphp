<?php

namespace Integrity\Calculator;

use Integrity\CalculatorInterface;
use Integrity\Review;

class Burst implements CalculatorInterface
{
	public function getModifier(Review $newReview, array $reviews)
	{
		$modifier = 0;
		$newDate = new \DateTime();
		$newDate->setTimestamp($newReview->getDate());
		
		foreach ($reviews as $review)
		{
			$date = new \DateTime();
			$date->setTimestamp($review->getDate());

			if($newDate->format('YmdH') == $date->format('YmdH')) {
				if($newDate->format('i') == $date->format('i')) {
					return -40;
				}
				$modifier = -20;
			}
		}
		return $modifier;
	}
}
