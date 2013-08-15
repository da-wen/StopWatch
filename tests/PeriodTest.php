<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 07.08.13
 * Time: 21:30
 * To change this template use File | Settings | File Templates.
 */
class PeriodTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Dawen\Component\StopWatch\Period */
    private $oPeriod;

    protected function setUp()
    {
        parent::setUp();
        $this->oPeriod = new \Dawen\Component\StopWatch\Period();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Dawen\Component\StopWatch\Period',$this->oPeriod);
        $this->assertTrue(is_float($this->oPeriod->getStarted()));
    }

    public function testGetStarted()
    {
        $this->assertTrue(is_float($this->oPeriod->getStarted()));
        $this->assertTrue(is_string($this->oPeriod->getStarted(5)));
    }

    public function testStop()
    {
        $this->assertNull($this->oPeriod->getEnd());
        $this->oPeriod->stop();
        $this->assertTrue(is_float($this->oPeriod->getEnd()));
        $this->assertTrue(is_string($this->oPeriod->getEnd(5)));

        $_oException = null;
        try
        {
            $this->oStopWatch->lap();
        }
        catch(\Exception $_oException)
        {

        }
        $this->assertNotNull($_oException);
        $this->assertInstanceOf('Exception', $_oException);
    }

    public function testDuration()
    {
        $this->assertTrue(is_float($this->oPeriod->getDuration()));
        $this->assertTrue($this->oPeriod->getDuration() < 0);
        $this->oPeriod->stop();
        $this->assertTrue($this->oPeriod->getDuration() > 0);
        $this->assertTrue(is_float($this->oPeriod->getDuration()));
        $this->assertTrue(is_string($this->oPeriod->getDuration(5)));
        $this->assertEquals(7, strlen($this->oPeriod->getDuration(5)));
    }

    public function testName()
    {
        $this->assertNull($this->oPeriod->getName());
        $_sName = 'myTestName';
        $this->oPeriod->setName($_sName);
        $this->assertEquals($_sName, $this->oPeriod->getName());
    }


}