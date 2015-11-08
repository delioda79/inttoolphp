<?php

namespace Integrity;

use Integrity\Calculator\AllStar;
use Integrity\Calculator\Burst;
use Integrity\Calculator\LongToSay;
use Integrity\Calculator\SameDevice;
use Integrity\Calculator\Solicited;

class Client
{
	private $advisors = [];
	
	function __construct()
	{
		$this->advisors[] = new Advisor('John');
		$this->advisors[] = new Advisor('Mark');
		$this->advisors[] = new Advisor('Ethan');
		
		$calculators = [];
		$calculators[] = new AllStar();
		$calculators[] = new Burst();
		$calculators[] = new LongToSay();
		$calculators[] = new SameDevice();
		$calculators[] = new Solicited();
		
		foreach($this->advisors as $advisor)
		{
			foreach($calculators as $calculator)
			{
				$advisor->addCalculator($calculator);
			}
		}
	}
	
	public function run()
	{
		echo "\nThis is an integrity tool. In this context we have\n 3 advisors".
		"whose names are: John, Mark, Ethan. You can send review informations\n".
		"in the format 12th July 12:04, Jon, solicited, LB3‐TYU, 50 words, *****\n".
		"Where the year is supposed the current one, solicited is one of the two types:".
		"solicited and unsolicited, LB3‐TYU is a case-sensitive string representing a ".
		"device type.\n";
		
		$exit = false;
		while(!$exit) {
			$line = trim(fgets(STDIN));
			if(strtolower($line) == 'quit') {
				$exit = true;
			} else {
				try {
					$data = split(',', $line);
					$advisor = $this->getAdvisor($data[1]);
					$advisor->addReview(new Review($data[0], $data[2], $data[3], $data[4], strlen($data[5])));
					echo $advisor->getScore();
				} catch(\Exception $e) {
					echo $e->getMessage();
				}
				
			}
		}
	}
	
	private function getAdvisor($name)
	{
		foreach($this->advisors as $advisor)
		{
			if ($advisor->getName() == $name) {
				return $advisor;
			}
			throw new \Exception("Advisor $name does not exist");
		}
	}
}