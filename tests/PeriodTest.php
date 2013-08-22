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
    }

    public function testDuration()
    {
        $this->assertTrue(is_string($this->oPeriod->getDuration()));
        $this->assertTrue($this->oPeriod->getDuration() < 0);
        $this->oPeriod->stop();
        $this->assertTrue($this->oPeriod->getDuration() > 0);
        $this->assertTrue(is_string($this->oPeriod->getDuration()));
        $this->assertTrue(is_string($this->oPeriod->getDuration(5)));
        $this->assertEquals(7, strlen($this->oPeriod->getDuration(5)));
        $this->assertEquals(9, strlen($this->oPeriod->getDuration(5, true)));
        $this->assertContains(' s', $this->oPeriod->getDuration(5, true));
    }

    public function testName()
    {
        $this->assertNull($this->oPeriod->getName());
        $_sName = 'myTestName';
        $this->oPeriod->setName($_sName);
        $this->assertEquals($_sName, $this->oPeriod->getName());
    }

    public function testStartMemory()
    {
        $_iMemoryUsage = $this->oPeriod->getStartMemoryUsage();
        $_sMemoryUsage = $this->oPeriod->getStartMemoryUsage(true);

        $this->assertTrue(is_int($_iMemoryUsage));
        $this->assertTrue(($_iMemoryUsage > 0));
        $this->assertTrue(is_string($_sMemoryUsage));
        $this->assertContains(' ', $_sMemoryUsage);
    }

    public function testEndMemory()
    {

        $this->oPeriod->stop();
        $_iMemoryUsage = $this->oPeriod->getEndMemoryUsage();
        $_sMemoryUsage = $this->oPeriod->getEndMemoryUsage(true);

        $this->assertTrue(is_int($_iMemoryUsage));
        $this->assertTrue(($_iMemoryUsage > 0));
        $this->assertTrue(is_string($_sMemoryUsage));
        $this->assertContains(' ', $_sMemoryUsage);
    }

    public function testGetMemory()
    {
        $_aTest = array();
        for($i = 0; $i <= 1000; $i++)
        {
            $_aTest[] = rand(1000, 10000000000);
        }
        $this->oPeriod->stop();

        $_iMemoryUsage = $this->oPeriod->getMemoryUsage();
        $_sMemoryUsage = $this->oPeriod->getMemoryUsage(true);

        $this->assertTrue(is_int($_iMemoryUsage));
        $this->assertTrue(($_iMemoryUsage > 0));
        $this->assertTrue(is_string($_sMemoryUsage));
        $this->assertContains(' kB', $_sMemoryUsage);
    }

}