<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 04.08.13
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */


namespace Dawen\Component\StopWatch;

class StopWatch
{
    private $aSections = array();

    public function getDuration($sSectionName = null, $iDecimals = 3, $bAddTimeUnit = true)
    {
        if(null !== $sSectionName && !isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        if(null !== $sSectionName)
        {
            return $this->getSectionDuration($this->aSections[$sSectionName], $iDecimals, $bAddTimeUnit);
        }

        $_fDuration = 0;
;
        foreach($this->aSections as $_sSectionName => $_aPeriods)
        {
            $_fDuration += $this->getSectionDuration($_aPeriods, $iDecimals);
        }

        return Util::getReadableTime($_fDuration, $bAddTimeUnit ,$iDecimals);

    }

    public function getSection($sSectionName = 'default')
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

    public function getMemoryUsage($sSectionName = null, $bFormat = true)
    {
        if(null !== $sSectionName && !isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        if(null !== $sSectionName)
        {
            return $this->getSectionMemoryUsage($this->aSections[$sSectionName], $bFormat);
        }

        $_iMemoryUsage = 0;
        foreach($this->aSections as $_sSectionName => $_aPeriods)
        {
            $_iMemoryUsage += $this->getSectionMemoryUsage($_aPeriods);
        }

        if($bFormat)
        {
            return Util::getReadableFileSize($_iMemoryUsage);
        }

        return $_iMemoryUsage;

    }

    public function lap($sSectionName = 'default', $sPeriodName = null)
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        try
        {
            $this->stop($sSectionName);
        }
        catch(\Exception $oException)
        {
            throw new \Exception('you can\'t call lap after stop');
        }

        $this->start($sSectionName, $sPeriodName = null);
    }

    public function start($sSectionName = 'default', $sPeriodName = null)
    {
        $this->aSections[$sSectionName][] = new Period($sPeriodName);
    }

    public function stop($sSectionName = 'default')
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('sections doesn\'s exist');
        }
        end($this->aSections[$sSectionName])->stop();
    }

    private function getSectionDuration(array $aPeriods, $iDecimals = 3, $bAddTimeUnit = false)
    {
        $_fDuration = 0;

        /** @var Period $_oPeriod */
        foreach($aPeriods as $_oPeriod)
        {
            $_fDuration += $_oPeriod->getDuration($iDecimals);
        }

        return Util::getReadableTime($_fDuration, $bAddTimeUnit, $iDecimals);
    }

    private function getSectionMemoryUsage(array $aPeriods, $bFormat = false)
    {
        $_iMemoryUsage = 0;

        /** @var Period $_oPeriod */
        foreach($aPeriods as $_oPeriod)
        {
            $_iMemoryUsage += $_oPeriod->getMemoryUsage();
        }

        if($bFormat)
        {
            return Util::getReadableFileSize($_iMemoryUsage);
        }

        return $_iMemoryUsage;

    }

}