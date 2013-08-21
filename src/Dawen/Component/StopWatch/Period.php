<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 04.08.13
 * Time: 11:27
 * To change this template use File | Settings | File Templates.
 */

namespace Dawen\Component\StopWatch;

class Period
{
    private $sName = null;

    private $fStarted = null;

    private $fEnd = null;

    private $iStartMemoryUsage = null;

    private $iEndMemoryUsage = null;

    public function __construct($sName = null)
    {
        $this->start();
        $this->sName = $sName;
    }

    public function getDuration($iDecimals = 3, $bAddTimeUnit = false)
    {
        $_fDuration = $this->fEnd - $this->fStarted;

        return Util::getReadableTime($_fDuration, $bAddTimeUnit, $iDecimals);
    }

    public function getStarted($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fStarted))
                    ? $this->fStarted
                    : number_format($this->fStarted, $iDecimals);
    }

    public function getMemoryUsage($bFormat = false)
    {
        $_iMemoryUsage = $this->iEndMemoryUsage - $this->iStartMemoryUsage;

        if($bFormat)
        {
            return Util::getReadableFileSize($_iMemoryUsage);
        }

        return $_iMemoryUsage;
    }

    public function getStartMemoryUsage($bFormat = false)
    {
        if($bFormat)
        {
            return Util::getReadableFileSize($this->iStartMemoryUsage);
        }

        return $this->iStartMemoryUsage;
    }

    public function getEndMemoryUsage($bFormat = false)
    {
        if($bFormat)
        {
            return Util::getReadableFileSize($this->iEndMemoryUsage);
        }

        return $this->iEndMemoryUsage;
    }

    public function getEnd($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fEnd) || null === $this->fEnd)
                    ? $this->fEnd
                    : number_format($this->fEnd, $iDecimals);
    }

    public function getName()
    {
        return $this->sName;
    }

    public function setName($sName)
    {
        $this->sName = $sName;
    }

    public function start()
    {
        $this->fStarted = microtime(true);
        $this->iStartMemoryUsage = memory_get_usage();
    }

    public function stop()
    {
        if(null !== $this->fEnd)
        {
            throw new \Exception('stop time is already set');
        }
        $this->iEndMemoryUsage = memory_get_usage();
        $this->fEnd = microtime(true);
    }

}
