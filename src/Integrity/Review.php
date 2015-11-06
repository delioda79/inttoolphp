<?php

namespace Integrity;

class Review
{
	private $date;
	private $type;
	private $device;
	private $length;
	private $stars;
	
	public function __construct($date, $type, $device, $length, $stars)
	{
		$this->date = $date;
		$this->type = $type;
		$this->device = $device;
		$this->length = $length;
		$this->stars = $stars;
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
