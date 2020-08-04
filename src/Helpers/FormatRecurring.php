<?php

namespace Spatie\CalendarLinks\Helpers;

class FormatRecurring
{
    public static function formatRecurPeriod($recur_period = null)
    {
        $recur = null;

        if ($recur_period) {
            switch (strtolower($recur_period)) {
                case "daily":
                    $recur = "RRULE:FREQ=DAILY";
                    break;
                case "weekly":
                    $recur = "RRULE:FREQ=WEEKLY";
                    break;
                case "weekdays":
                    $recur = "RRULE:FREQ=WEEKLY;BYDAY=MO,TU,WE,TH,FR";
                    break;
                case "monthly":
                    $recur = "RRULE:FREQ=MONTHLY";
                    break;
                default:
                    $recur = null;
                    break;
            }
        }
        return $recur;
    }
}
