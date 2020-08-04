<?php

namespace Spatie\CalendarLinks\Generators;

use DateTimeZone;
use Spatie\CalendarLinks\Generator;
use Spatie\CalendarLinks\Link;

/**
 * @see https://github.com/InteractionDesignFoundation/add-event-to-calendar-docs/blob/master/services/outlook-live.md
 */
class WebOutlook implements Generator
{
    /** @var string {@see https://www.php.net/manual/en/function.date.php} */
    protected $dateFormat = 'Y-m-d';
    protected $dateTimeFormat = 'Y-m-d\TH:i:s\Z';

    /** {@inheritdoc} */
    public function generate(Link $link): string
    {
        $url = 'https://outlook.live.com/calendar/deeplink/compose?path=/calendar/action/compose&rru=addevent';

        $dateTimeFormat = $link->allDay ? $this->dateFormat : $this->dateTimeFormat;

        $startTimeZone = $link->from->getTimezone();
        $endTimeZone = $link->to->getTimezone();

        $startDateTime = (clone $link->from)->setTimezone($startTimeZone);
        $endDateTime = (clone $link->to)->setTimezone($endTimeZone);

        $url .= '&startdt='.$startDateTime->format($dateTimeFormat);
        $url .= '&enddt='.$endDateTime->format($dateTimeFormat);

        if ($link->allDay) {
            $url .= '&allday=true';
        }

        $url .= '&subject='.urlencode($link->title);

        if ($link->description) {
            $url .= '&body='.urlencode($link->description);
        }

        if ($link->address) {
            $url .= '&location='.urlencode($link->address);
        }

        return $url;
    }
}
