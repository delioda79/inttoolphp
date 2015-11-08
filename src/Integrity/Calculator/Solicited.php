<?php

namespace Integrity\Calculator;

use Integrity\CalculatorInterface;
use Integrity\Review;

class Solicited implements CalculatorInterface
{
	const SOLICITED = 'solicited';
	const UNSOLICITED = 'unsolicited';

	public function getModifier(Review $review, array $reviews)
	{
		return $review->getType() == $this::SOLICITED ? 3 : 0;
	}
}
