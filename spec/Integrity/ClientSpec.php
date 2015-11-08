<?php

namespace spec\Integrity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
	protected $advisor1;
	protected $advisor2;
	protected $calculator1;
	protected $calculator2;
	protected $stream;
	
	function let($advisor1, $advisor2, $calculator1, $calculator2, $stream)
	{
		$advisor1->beADoubleOf('Integrity\Advisor');
		$advisor1->beConstructedWith(['Advisor1']);
		$advisor2->beADoubleOf('Integrity\Advisor');
		$advisor2->beConstructedWith(['Advisor2']);
		 
		$calculator1->beADoubleOf('Integrity\CalculatorInterface');
		$calculator2->beADoubleOf('Integrity\CalculatorInterface');
		 
		$stream->beADoubleOf('Integrity\StreamInterface');
		$this->beConstructedWith([$advisor1, $advisor2], [$calculator1, $calculator2], $stream);
		
		$advisor1->addCalculator($calculator1)->willReturn();
		$advisor1->addCalculator($calculator2)->willReturn();
		$advisor1->addReview(Argument::any())->willReturn(100);
		$advisor1->getScore(Argument::any())->willReturn(100);
		$advisor1->getStatus()->willReturn(2);
		
		$advisor2->addCalculator($calculator1)->willReturn();
		$advisor2->addCalculator($calculator2)->willReturn();
		$advisor2->getStatus()->willReturn(2);
		
		$advisor1->getName()->willReturn('Advisor1');
		$advisor2->getName()->willReturn('Advisor2');
		$stream->sendData(Argument::type('string'))->willReturn("Start");
		$stream->sendData(Argument::type('int'))->willReturn(100);
		
		$stream->sendData("\n")->will(function($stream) {
			$this->readData()->willReturn('quit');
		});
		
		$this->advisor1 = $advisor1;
		$this->advisor2 = $advisor2;
		$this->calculator1 = $calculator1;
		$this->calculator2 = $calculator2;
		$this->stream = $stream;
	}
	
    function it_is_initializable()
    {
    	$this->shouldHaveType('Integrity\Client');
    }

    function it_returns_correct_score()
    {
    	
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50,**');
    	
    	$this->run();
    	$this->stream->sendData(100)->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_wrong_date()
    {
    	$this->stream->readData()->willReturn('wrongDate, Advisor1,solicited, DEV1,50,**');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_wrong_stars()
    {
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50,a');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_wrong_type()
    {    
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,soliciteda, DEV1,50,***');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50,**');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_wrong_arguments_number()
    {
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50');
    	$this->run();
    	$this->stream->sendData("Could not read review summary data")->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_wrong_advisor()
    {
		$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor3,solicited, DEV1,50,**');
    	$this->run();
    	$this->stream->sendData("Advisor Advisor3 does not exist")->shouldHaveBeenCalled();
    }
    
    function it_should_alert_on_deactivated_advisor()
    {
    	$this->stream->readData()->willReturn('2018-01-01 11:30, Advisor1,solicited, DEV1,50,**');
    	$this->advisor1->getStatus()->willReturn(0);
    	$this->run();
    	$this->stream->sendData("Advisor Advisor1 does not exist")->shouldHaveBeenCalled();
    }
}
