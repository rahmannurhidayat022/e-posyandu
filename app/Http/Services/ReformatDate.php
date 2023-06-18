<?php

namespace App\Http\Services;

use Illuminate\Support\Carbon;

class ReformatDate
{
    public static function updateDateTimeTimezone(string $datetimeString): string
    {
        $carbon = Carbon::parse($datetimeString);
        $carbon->setTimezone("Asia/Jakarta");

        return $carbon->format("d-m-Y");
    }

    public static function convertTimestampToDateTime(int $timestamp): string
    {
        $carbon = Carbon::createFromTimestamp($timestamp);
        $carbon->setTimezone("Asia/Jakarta");

        return $carbon->format("d-m-Y");
    }
}
