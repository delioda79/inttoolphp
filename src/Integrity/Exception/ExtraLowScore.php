<?php

namespace Integrity\Exception;

class ExtraLowScore extends \Exception
{
	public function __construct($name, $code = 0, Exception $previous = null) {
		parent::__construct("Alert: $name has been de‐activated due to a low trusted review score", $code, $previous);
	}
}
