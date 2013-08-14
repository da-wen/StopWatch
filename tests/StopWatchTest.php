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
}