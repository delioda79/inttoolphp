<?php
namespace Integrity;

interface CalculatorInterface
{
	public function getModifier(Review $review, array $reviews);	
}