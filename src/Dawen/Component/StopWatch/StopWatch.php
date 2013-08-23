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
    /** @var array  */
    private $aSections = array();

    /**
     * gets the duration of all sections or only one specified section
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param null|string $sSectionName
     * @param int $iDecimals
     * @param bool $bAddTimeUnit
     *
     * @return string
     * @throws \Exception
     */
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

    /**
     * returns an array of periods for a section
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param string $sSectionName
     *
     * @return array
     * @throws \Exception
     */
    public function getSection($sSectionName = 'default')
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('section doesn\'s exist');
        }

        return $this->aSections[$sSectionName];
    }

    /**
     * returns an array of all sections
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @return array
     */
    public function getSections()
    {
        return $this->aSections;
    }

    /**
     * gets memory usage for all sections or on specified sections.
     * function returns an integer (bytes) or a formatted string
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param null|string $sSectionName
     * @param bool $bFormat
     *
     * @return int|null|string
     * @throws \Exception
     */
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

    /**
     * closed and opens a new period.
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param string $sSectionName
     * @param null|string $sPeriodName
     *
     * @return void
     * @throws \Exception
     */
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

    /**
     * starts a period (sets start microtime and memory usage)
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param string $sSectionName
     * @param null|string $sPeriodName
     */
    public function start($sSectionName = 'default', $sPeriodName = null)
    {
        $this->aSections[$sSectionName][] = new Period($sPeriodName);
    }

    /**
     * stops a period (sets start microtime and memroy usage)
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param string $sSectionName
     *
     * @throws \Exception
     * @return void
     */
    public function stop($sSectionName = 'default')
    {
        if(!isset($this->aSections[$sSectionName]))
        {
            throw new \Exception('sections doesn\'s exist');
        }
        end($this->aSections[$sSectionName])->stop();
    }

    /**
     * gets sections duration (optional time unit)
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param array $aPeriods
     * @param int $iDecimals
     * @param bool $bAddTimeUnit
     *
     * @return string
     */
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

    /**
     * gets section memory usage (optional size unit)
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param array $aPeriods
     * @param bool $bFormat
     *
     * @return int|null|string
     */
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