<?php

namespace Spatie\CalendarLinks\Generators;

use Spatie\CalendarLinks\Generator;
use Spatie\CalendarLinks\Link;

/**
 * @see https://github.com/InteractionDesignFoundation/add-event-to-calendar-docs/blob/master/services/google.md
 */
class Google implements Generator
{
    /** @var string {@see https://www.php.net/manual/en/function.date.php} */
    protected $dateFormat = 'Ymd';
    protected $dateTimeFormat = 'Ymd\THis';

    /** {@inheritdoc} */
    public function generate(Link $link): string
    {
        $url = 'https://calendar.google.com/calendar/render?action=TEMPLATE';

        $dateTimeFormat = $link->allDay ? $this->dateFormat : $this->dateTimeFormat;
        $url .= '&dates='.$link->from->format($dateTimeFormat).'/'.$link->to->format($dateTimeFormat);
        $url .= '&ctz='.$link->from->getTimezone()->getName();

        $url .= '&text='.urlencode($link->title);

        if ($link->description) {
            $url .= '&details='.urlencode($link->description);
        }

        if ($link->address) {
            $url .= '&location='.urlencode($link->address);
        }

        if ($link->recurPeriod) {
            switch (strtolower($link->recurPeriod)) {
                case "daily":
                    $recur = "&recur=RRULE:FREQ=DAILY";
                    break;
                case "weekly":
                    $recur = "&recur=RRULE:FREQ=WEEKLY";
                    break;
                case "weekdays":
                    $recur = "&recur=RRULE:FREQ=WEEKLY;BYDAY=MO,TU,WE,TH,FR";
                    break;
                case "monthly":
                    $recur = "&recur=RRULE:FREQ=MONTHLY";
                    break;
                default:
                    $recur = null;
                    break;
            }
            if ($recur && $link->recurUntil) {
                $url .= '&recur='.urlencode($recur).';UNTIL='.$link->recurUntil->format('Ymd');
            }
        }

        $url .= '&sprop=&sprop=name:';

        return $url;
    }
}
