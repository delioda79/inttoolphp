<?php

namespace Integrity\Exception;

class PastDateReview extends \Exception
{
	public function __construct($code = 0, Exception $previous = null) {
		parent::__construct("Review can't be older than any of the existing ones", $code, $previous);
	}
}
