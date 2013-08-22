<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 07.08.13
 * Time: 21:30
 * To change this template use File | Settings | File Templates.
 */
class StopWatchTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Dawen\Component\StopWatch\StopWatch */
    private $oStopWatch;

    protected function setUp()
    {
        parent::setUp();
        $this->oStopWatch = new \Dawen\Component\StopWatch\StopWatch();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Dawen\Component\StopWatch\StopWatch', $this->oStopWatch);
    }

    public function testSection()
    {
        $_sSection = 'testSection';
        $this->oStopWatch->start($_sSection);

        $_aSections = $this->oStopWatch->getSections();

        $this->assertCount(1, $_aSections);
        $this->assertTrue(array_key_exists($_sSection, $_aSections));

        $_aSection = $this->oStopWatch->getSection($_sSection);
        $this->assertCount(1, $_aSection);

        $this->assertInstanceOf('Dawen\Component\StopWatch\Period', current($_aSection));
    }

    public function testGetSectionException()
    {

        try
        {
            $this->oStopWatch->getSection('testing');
        }
        catch(\Exception $_oException)
        {
            $this->assertTrue(true);
            return true;
        }

        $this->assertFalse(true);
    }

    public function testStop()
    {
        //test default section
        $this->oStopWatch->start();

        //test section
        $_sSection = 'myTestSection';
        $this->oStopWatch->start($_sSection);

        $this->oStopWatch->stop();
        $this->oStopWatch->stop($_sSection);

        $_aDefaultSection = $this->oStopWatch->getSection();
        $_aSection = $this->oStopWatch->getSection($_sSection);

        $this->assertCount(1, $_aDefaultSection);
        $this->assertCount(1, $_aSection);

        $this->assertNotNull($_aDefaultSection[0]->getEnd());
        $this->assertNotNull($_aSection[0]->getEnd());
    }

    public function testStopSectionException()
    {
        $this->oStopWatch->start();
        try
        {
            $this->oStopWatch->stop('asd');
        }
        catch(\Exception $_oException)
        {
            $this->assertTrue(true);
            return true;
        }

        $this->assertFalse(true);
    }

    public function testLap()
    {
        $this->oStopWatch->start();
        $this->oStopWatch->lap();
        $this->oStopWatch->lap();
        $_aPeriods = $this->oStopWatch->getSection();
        $this->assertCount(3, $_aPeriods);
        $this->assertNull(end($_aPeriods)->getEnd());
        $this->oStopWatch->stop();
        $this->assertNotNull(end($_aPeriods)->getEnd());

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

   public function testLapSectionException()
   {
       $this->oStopWatch->start();
       try
       {
           $this->oStopWatch->lap('asd');
       }
       catch(\Exception $_oException)
       {
           $this->assertTrue(true);
           return true;
       }

       $this->assertFalse(true);
   }

    public function testDuration()
    {
        $this->oStopWatch->start();
        usleep(1000);
        for($i = 0; $i <= 100; $i++)
        {
            $this->oStopWatch->lap();
            usleep(1000);
        }
        usleep(1000);
        $this->oStopWatch->stop();

        $_sSection = 'myTestSection';

        $this->oStopWatch->start($_sSection);
        usleep(1000);
        for($i = 0; $i <= 50; $i++)
        {
            $this->oStopWatch->lap($_sSection);
            usleep(1000);
        }
        usleep(1000);
        $this->oStopWatch->stop($_sSection);

        $_fAll = $this->oStopWatch->getDuration();
        $_fSection = $this->oStopWatch->getDuration($_sSection);

        $this->assertTrue(is_string($_fAll));
        $this->assertTrue(is_string($_fSection));
        $this->assertEquals(7, strlen($_fSection));
        $this->assertTrue($_fAll > $_fSection);

    }

    public function testDurationFormat()
    {
        $this->oStopWatch->start();
        usleep(1000);
        for($i = 0; $i <= 100; $i++)
        {
            $this->oStopWatch->lap();
            usleep(1000);
        }
        usleep(1000);
        $this->oStopWatch->stop();


        $_sAll = $this->oStopWatch->getDuration(null, 2);
        $_sSectionDurationDecimals = $this->oStopWatch->getDuration('default', 5);

        $this->assertTrue(is_string($_sAll));
        $this->assertEquals(6, strlen($_sAll));

        $this->assertTrue(is_string($_sSectionDurationDecimals));
        $this->assertEquals(9, strlen($_sSectionDurationDecimals));

    }

    public function testDurationException()
    {
        $this->oStopWatch->start();
        usleep(1000);
        for($i = 0; $i <= 100; $i++)
        {
            $this->oStopWatch->lap();
            usleep(1000);
        }
        usleep(1000);
        $this->oStopWatch->stop();

        try
        {
            $_sAll = $this->oStopWatch->getDuration('asd');
        }
        catch(\Exception $_oException)
        {
            $this->assertTrue(true);
            return true;
        }

        $this->assertFalse(true);

    }

    public function testMemoryUsage()
    {
        $this->oStopWatch->start();
        usleep(1000);
        $_aTest = array();
        for($i = 0; $i <= 1000; $i++)
        {
            $_iRand = rand(1000, 1000000000000);
            $_iTest = hash('sha256', $_iRand);
            $_aTest[] = $_iTest;
            $_aTest[] = $_iRand;
            $this->oStopWatch->lap();
            usleep(1000);
        }

        usleep(1000);
        $this->oStopWatch->stop();

        $_iMemoryUsage = $this->oStopWatch->getMemoryUsage(null, false);
        $_sMemoryUsage = $this->oStopWatch->getMemoryUsage();
        $_iMemoryUsageSection = $this->oStopWatch->getMemoryUsage('default', false);
        $_sMemoryUsageSection = $this->oStopWatch->getMemoryUsage('default', true);


        $this->assertTrue(is_int($_iMemoryUsage));
        $this->assertTrue(($_iMemoryUsage > 0));

        $this->assertTrue(is_string($_sMemoryUsage));

        $this->assertTrue(is_int($_iMemoryUsageSection));
        $this->assertTrue(($_iMemoryUsageSection > 0));

        $this->assertTrue(is_string($_sMemoryUsageSection));

        $this->assertEquals($_iMemoryUsage, $_iMemoryUsageSection);
        $this->assertEquals($_sMemoryUsage, $_sMemoryUsageSection);

        $this->oStopWatch->start('test');
        $_sTest = 'blub';
        $this->oStopWatch->stop('test');

        $_iMemoryUsageTestSection = $this->oStopWatch->getMemoryUsage('test', false);

        $this->assertTrue(($_iMemoryUsageTestSection > 0));
        $this->assertTrue(($_iMemoryUsageSection > $_iMemoryUsageTestSection));

    }

    public function testMemoryException()
    {
        $this->oStopWatch->start();
        usleep(1000);
        for($i = 0; $i <= 100; $i++)
        {
            $this->oStopWatch->lap();
            usleep(1000);
        }
        usleep(1000);
        $this->oStopWatch->stop();

        try
        {
            $_sAll = $this->oStopWatch->getMemoryUsage('asd');
        }
        catch(\Exception $_oException)
        {
            $this->assertTrue(true);
            return true;
        }

        $this->assertFalse(true);

    }


}