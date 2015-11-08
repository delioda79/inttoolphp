<?php

namespace Integrity\Exception;

class InvalidAdvisor extends \Exception
{
	public function __construct($name, $code = 0, Exception $previous = null) {
		parent::__construct("Advisor $name does not exist", $code, $previous);
	}
}
