<?php

namespace Integrity;

use Integrity\Exception\InvalidAdvisor;
use Integrity\Exception\LowScore;
use Integrity\Exception\ExtraLowScore;
use Integrity\Exception\InvalidData;

class Client
{
	private $advisors = [];
	private $stream;
	
	function __construct($advisors, $calculators, StreamInterface $stream)
	{
		$this->advisors = $advisors;
		$this->stream = $stream;
		
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
		$welcome = "\nThis is an integrity tool. In this context we have\n 3 advisors".
		"whose names are: " .implode(', ', $this->getAdvisorNames()) .". You can send review informations\n".
		"in the format 12th July 12:04, Jon, solicited, LB3‐TYU, 50 words, *****\n".
		"Where the year is supposed the current one, solicited is one of the two types:".
		"solicited and unsolicited, LB3‐TYU is a case-sensitive string representing a ".
		"device type.\n";
		
		$this->stream->sendData($welcome);
		
		$exit = false;
		while(!$exit) {
			$line = trim($this->stream->readData());
			if(strtolower($line) == 'quit') {
				$exit = true;
			} else {
				try {
					$data = explode(',', $line);
					
					$this->validateData($data);
					
					$advisor = $this->getAdvisor(trim($data[1]));
					$advisor->addReview(new Review(strtotime(trim($data[0])), trim($data[2]), trim($data[3]), (int) trim($data[4]), strlen(trim($data[5]))));
					$this->stream->sendData($advisor->getScore());
				} catch(InvalidAdvisor $e) {
					$this->stream->sendData($e->getMessage());
				} catch (LowScore $e) {
					$this->stream->sendData($e->getMessage());
				} catch (ExtraLowScore $e) {
					$this->stream->sendData($e->getMessage());
				} catch(\Exception $e) {
					$this->stream->sendData($e->getMessage());
				}
				
			}
			$this->stream->sendData("\n");
		}
	}
	
	private function getAdvisor($name)
	{
		foreach($this->advisors as $advisor)
		{
			if ($advisor->getName() == $name) {
				return $advisor;
			}
		}
		throw new InvalidAdvisor($name);
	}
	
	private function validateData($data)
	{
		//We need 6 params
		if (count($data) < 6) {
			throw new InvalidData();
		}
		//last argument must be a set of stars
		if (str_replace('*', '', $data[5]) !== '') {
			throw new InvalidData();
		}
		
		try{
			$date = new \DateTime($data[0]);
		} catch(\Exception $e) {
			throw new InvalidData();
		}
	}
	
	private function getAdvisorNames()
	{
		$names = [];
		foreach ($this->advisors as $advisor)
		{
			$names[] = $advisor->getName();
		}
		
		return $names;
	}
}