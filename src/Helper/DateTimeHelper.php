<?php

namespace App\Helper;

use DateTime;

/**
 * Class DateTime
 * @package App\Helper
 */
final class DateTimeHelper
{
    public const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * @return string
     */
    public static function getDateTimeNow()
    {
        return (new DateTime('now'))->format(self::DATE_TIME_FORMAT);
    }
}

