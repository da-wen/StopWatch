<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dawen
 * Date: 17.08.13
 * Time: 13:07
 * To change this template use File | Settings | File Templates.
 */

class Util
{
    public static function formatTime($fNumber, $iDecimals = null, $bAddTimeFormatString = false)
    {

        if(null !== $iDecimals)
        {
            $fNumber = floatval(number_format($fNumber, $iDecimals, '.', ''));
        }

        if($bAddTimeFormatString)
        {
            if($fNumber >= 60)
            {
                $fNumber = $fNumber / 60;
                $fNumber = floatval(number_format($fNumber, $iDecimals, '.', ''));
                $fNumber .= 'm';
            }
            else
            {
                $fNumber .= 's';
            }
        }

        return $fNumber;
    }


}