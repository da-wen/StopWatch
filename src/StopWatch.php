<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 04.08.13
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */


namespace Dawen\PhpLoggerTest\StopWatch;

class StopWatch
{
    private $aSections = array();

    public function getDuration($sSectionName = null, $iDecimals = null)
    {
        if(null !== $sSectionName && !isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        $_fDuration = 0;
        if(null !== $sSectionName)
        {
            return $this->getSectionDuration($this->aSections[$sSectionName], $iDecimals);
        }

        foreach($this->aSections as $_sSectionName => $_aPeriods)
        {
            $_fDuration += $this->getSectionDuration($_aPeriods);
        }

        if(null !== $iDecimals)
        {
            $_fDuration = number_format($_fDuration, $iDecimals);
        }

        return $_fDuration;

    }

    public function getSection($sSectionName)
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        return $this->aSections[$sSectionName];
    }

    public function getSections()
    {
        return $this->aSections;
    }

    public function lap($sSectionName, $sPeriodName = null)
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        $this->stop($sSectionName);
        $this->start($sSectionName, $sPeriodName = null);
    }

    public function start($sSectionName, $sPeriodName = null)
    {
        $this->aSections[$sSectionName][] = new Period($sPeriodName);
    }

    public function stop($sSectionName)
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('sections doesn\'s exist');
        }
        end($this->aSections[$sSectionName])->stop();
    }

    private function getSectionDuration(array $aPeriods, $iDecimals = null)
    {
        $_fDuration = 0;

        /** @var Period $_oPeriod */
        foreach($aPeriods as $_oPeriod)
        {
            $_fDuration += $_oPeriod->getDuration($iDecimals);
        }

        return $_fDuration;
    }

}