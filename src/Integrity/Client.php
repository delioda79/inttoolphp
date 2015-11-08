<?php

namespace Integrity;

use Integrity\Exception\InvalidAdvisor;
use Integrity\Exception\LowScore;
use Integrity\Exception\ExtraLowScore;
use Integrity\Exception\InvalidData;

/**
 * This class implements a client for a stateful application
 * for calculating integrity score. It makes use of a list of
 * Advisors (instances of Advicor class), Calculators
 * (implementing CalculatorInterface) and of a stream.
 * The stream Interface provides a way to communicate
 * through a simple api and is useful when creating
 * a command line tool needing to communicate with this client.
 * It is also adds an easy way to tests the client.
 * @author delio
 * 
 */
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
			if ($advisor->getName() == $name && $advisor->getStatus() > Advisor::STATUS_INACTIVE) {
				return $advisor;
			}
		}
		throw new InvalidAdvisor($name);
	}
	
	/**
	 * This function validates the input
	 * that will be sent to the advisor.
	 * The run method will have to modify
	 * the user inputs so that the format
	 * is suitable for being sent to
	 * Advisor::addReview. The data the
	 * user inputs are slightly different
	 * in format from what Advisor expects,
	 * this functions validates the input
	 * so that is then possible to transform it
	 * and send it to Advisor
	 * 
	 * @param array $data
	 * @throws InvalidData
	 */
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
	
	/**
	 * Utility function that retrieves a list
	 * with the names of the available Advisors
	 */
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