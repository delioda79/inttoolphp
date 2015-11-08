<?php

namespace Integrity\Exception;

class InvalidData extends \Exception
{
	public function __construct($code = 0, Exception $previous = null) {
		parent::__construct("Could not read review summary data", $code, $previous);
	}
}
