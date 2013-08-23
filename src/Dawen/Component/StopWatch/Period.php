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
    /** @var string  */
    private $sName = null;

    /** @var float  */
    private $fStarted = null;

    /** @var float */
    private $fEnd = null;

    /** @var int */
    private $iStartMemoryUsage = null;

    /** @var int  */
    private $iEndMemoryUsage = null;

    /**
     * constuctor of period class
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param null|string $sName
     */
    public function __construct($sName = null)
    {
        $this->start();
        $this->sName = $sName;
    }

    /**
     * gets formatted duration of this period
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param int $iDecimals
     * @param bool $bAddTimeUnit
     * @return string
     */
    public function getDuration($iDecimals = 3, $bAddTimeUnit = false)
    {
        $_fDuration = $this->fEnd - $this->fStarted;

        return Util::getReadableTime($_fDuration, $bAddTimeUnit, $iDecimals);
    }

    /**
     * gets pure or formatted start microtime
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param null|int $iDecimals
     * @return float|null|string
     */
    public function getStarted($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fStarted))
                    ? $this->fStarted
                    : number_format($this->fStarted, $iDecimals);
    }

    /**
     * gets memory usage as integer (bytes) or as string
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param bool $bFormat
     * @return int|null|string
     */
    public function getMemoryUsage($bFormat = false)
    {
        $_iMemoryUsage = $this->iEndMemoryUsage - $this->iStartMemoryUsage;

        if($bFormat)
        {
            return Util::getReadableFileSize($_iMemoryUsage);
        }

        return $_iMemoryUsage;
    }

    /**
     * gets start memory usage as int (bytes) or formatted string
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param bool $bFormat
     * @return int|null|string
     */
    public function getStartMemoryUsage($bFormat = false)
    {
        if($bFormat)
        {
            return Util::getReadableFileSize($this->iStartMemoryUsage);
        }

        return $this->iStartMemoryUsage;
    }

    /**
     * gets endpoint memory usae as integer (bytes) or as formatted string
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param bool $bFormat
     * @return int|null|string
     */
    public function getEndMemoryUsage($bFormat = false)
    {
        if($bFormat)
        {
            return Util::getReadableFileSize($this->iEndMemoryUsage);
        }

        return $this->iEndMemoryUsage;
    }

    /**
     * gets the microtime sd flost or formatted string of the endpoint
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param null $iDecimals
     * @return float|null|string
     */
    public function getEnd($iDecimals = null)
    {
        return (null === $iDecimals || !is_float($this->fEnd) || null === $this->fEnd)
                    ? $this->fEnd
                    : number_format($this->fEnd, $iDecimals);
    }

    /**
     * gets the set name of this period
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->sName;
    }

    /**
     * sets the name for this period
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @param string $sName
     */
    public function setName($sName)
    {
        $this->sName = $sName;
    }

    /**
     * starts this period
     * also called in constructor. can be used for resetting the starttime
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @return void
     */
    public function start()
    {
        $this->fStarted = microtime(true);
        $this->iStartMemoryUsage = memory_get_usage();
    }

    /**
     * stops this period and sets microtime and memory usage for this period.
     *
     * @author dawen
     * @since 2013-08-23
     *
     * @throws \Exception
     * @return void
     */
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
