<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 17.08.13
 * Time: 13:07
 * To change this template use File | Settings | File Templates.
 */
namespace Dawen\Component\StopWatch;

class Util
{

    public static function getReadableFileSize($iSize, $sFormat = null) {
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $_aSizes = array('bytes', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        if ($sFormat === null)
        {
            $sFormat = '%01.2f %s';
        }

        $_sLastSizeString = end($_aSizes);

        foreach ($_aSizes as $_sSizeString) {
            if ($iSize < 1024)
            {
                break;
            }

            if ($_sSizeString != $_sLastSizeString)
            {
                $iSize /= 1024;
            }
        }

        if ($_sSizeString == $_aSizes[0])
        {
            $sFormat = '%01d %s';
        } // Bytes aren't normally fractional

        return sprintf($sFormat, $iSize, $_sSizeString);
    }

    public static function getReadableTime($fTime, $bAddTimeUnit = true,$iDecimals = 3)
    {
        $_fRet = $fTime;
        $_iFormatter = 0;
        $_aFormats = array('s', 'm');

        if($fTime >= 60) {
            $_iFormatter = 1;
            $_fRet = ($fTime / 60);
        }
        $_fRet = number_format($_fRet, $iDecimals,'.','');

        if($bAddTimeUnit)
        {
            $_fRet .= ' ' . $_aFormats[$_iFormatter];
        }

        return $_fRet;
    }


}