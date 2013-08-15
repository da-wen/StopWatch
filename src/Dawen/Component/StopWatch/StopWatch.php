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

    public function getDuration($sSectionName = null, $iDecimals = null)
    {
        if(null !== $sSectionName && !isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        if(null !== $sSectionName)
        {
            return $this->getSectionDuration($this->aSections[$sSectionName], $iDecimals);
        }

        $_fDuration = 0;
;
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

    private function getSectionDuration(array $aPeriods, $iDecimals = null)
    {
        $_fDuration = 0;

        /** @var Period $_oPeriod */
        foreach($aPeriods as $_oPeriod)
        {
            $_fDuration += $_oPeriod->getDuration();
        }

        if(null !== $iDecimals)
        {
            $_fDuration = number_format($_fDuration, $iDecimals);
        }
        return $_fDuration;
    }

}