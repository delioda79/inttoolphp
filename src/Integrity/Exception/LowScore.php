<?php

namespace Integrity\Exception;

class LowScore extends \Exception
{
	public function __construct($name, $score, $code = 0, Exception $previous = null) {
		parent::__construct("Warning: $name has a trusted review score of $score", $code, $previous);
	}

}
