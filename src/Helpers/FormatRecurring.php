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
                    $recur = "DAILY";
                    break;
                case "weekly":
                    $recur = "WEEKLY";
                    break;
                case "weekdays":
                    $recur = "WEEKLY;BYDAY=MO,TU,WE,TH,FR";
                    break;
                case "monthly":
                    $recur = "MONTHLY";
                    break;
                default:
                    $recur = null;
                    break;
            }
        }
        return $recur;
    }
}
