<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 04.08.13
 * Time: 11:27
 * To change this template use File | Settings | File Templates.
 */

namespace Dawen\PhpLoggerTest\StopWatch;

class Period
{
    private $sName = null;

    private $fStarted = null;

    private $fEnd = null;

    public function __construct($sName = null)
    {
        $this->fStarted = microtime(true);
        $this->sName = $sName;
    }

    public function getDuration($iDecimals = null)
    {
        $_fDuration = $this->fEnd - $this->fStarted;

        if(null === $iDecimals || !is_float($iDecimals))
        {
            return $_fDuration;
        }

        return number_format($_fDuration, $iDecimals);
    }

    public function getStarted($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fStarted))
                    ? $this->fStarted
                    : number_format($this->fStarted, $iDecimals);
    }

    public function getEnd($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fEnd) || null === $this->fEnd)
                    ? $this->fEnd
                    : number_format($this->fEnd, $iDecimals);
    }

    public function setName($sName)
    {
        $this->sName = $sName;
    }

    public function start()
    {
        $this->fStarted = microtime(true);
    }

    public function stop()
    {
        $this->fEnd = microtime(true);
    }

}