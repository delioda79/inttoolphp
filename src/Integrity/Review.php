<?php

namespace Integrity;

use Integrity\Exception\InvalidData;
class Review
{
	const TYPE_SOLICITED = 'solicited';
	const TYPE_UNSOLICITED = 'unsolicited';
	
	private $date;
	private $type;
	private $device;
	private $length;
	private $stars;
	
	public function __construct($date, $type, $device, $length, $stars)
	{
		//Validating the input
		if (!is_numeric($date) || !is_numeric($date) ||
				!is_numeric($length) ||
				!is_numeric($stars) ||
				$stars > 5 || $stars < 0 ||
				!in_array($type, [$this::TYPE_SOLICITED, $this::TYPE_UNSOLICITED]))
		{
			throw new InvalidData();
		}
		$this->date = (int) $date;
		$this->type = $type;
		$this->device = $device;
		$this->length = (int) $length;
		$this->stars = (int) $stars;
	}
	
	public function getDate()
	{
		return $this->date;
	}
	
	public function getType()
	{
		return $this->type;
	}
	
	public function getDevice()
	{
		return $this->device;
	}
	
	public function getLength()
	{
		return $this->length;
	}
	
	public function getStars()
	{
		return $this->stars;
	}
}
