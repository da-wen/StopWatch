<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 17.08.13
 * Time: 13:20
 * To change this template use File | Settings | File Templates.
 */

class UtilTest extends \PHPUnit_Framework_TestCase
{

    public function testGetReadableTime()
    {
        $_fNumber = 0.0000000444;
        $_sFomatted3 = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, false);
        $this->assertEquals(0, $_sFomatted3);
        $this->assertEquals(5, strlen($_sFomatted3));

        $_sFomatted = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, false, 10);
        $this->assertEquals($_fNumber, $_sFomatted);
    }

    public function testGetReadableTimeUit()
    {

        $_fNumber = 0.0000000444;

        //time unit
        $_sFomattedUnit3 = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, true);
        $this->assertEquals(7, strlen($_sFomattedUnit3));
        $this->assertContains(' s', $_sFomattedUnit3);

        $_sFomattedUnit8 = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, true, 8);
        $this->assertEquals(12, strlen($_sFomattedUnit8));
        $this->assertContains('4 s', $_sFomattedUnit8);

        $_fNumber = 6.0000000444;
        $_sFomattedUnitM = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, true);
        $this->assertEquals(7, strlen($_sFomattedUnitM));
        $this->assertContains(' s', $_sFomattedUnitM);

        $_fNumber = 3600.0000000444;

        $_sFomattedUnitM = \Dawen\Component\StopWatch\Util::getReadableTime($_fNumber, true);
        $this->assertEquals(8, strlen($_sFomattedUnitM));
        $this->assertContains(' m', $_sFomattedUnitM);
    }

    public function testGetReadableFileSize()
    {
        $this->assertContains('8 bytes', \Dawen\Component\StopWatch\Util::getReadableFileSize(8));
        $this->assertContains('1.00 kB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024));
        $this->assertContains('1.00 MB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024));
        $this->assertContains('1.00 GB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024));
        $this->assertContains('1.00 TB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024*1024));
        $this->assertContains('1.00 PB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024*1024*1024));
        $this->assertContains('1.00 EB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024*1024*1024*1024));
        $this->assertContains('1.00 ZB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024*1024*1024*1024*1024));
        $this->assertContains('1.00 YB', \Dawen\Component\StopWatch\Util::getReadableFileSize(1024*1024*1024*1024*1024*1024*1024*1024));
    }

    public function testGetReadableFileSizeFormatting()
    {
        $this->assertContains('129.3  kB', \Dawen\Component\StopWatch\Util::getReadableFileSize(132402, '%01.1f  %s'));
    }

}