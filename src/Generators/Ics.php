<?php

namespace Spatie\CalendarLinks\Generators;

use Spatie\CalendarLinks\Generator;
use Spatie\CalendarLinks\Helpers\FormatRecurring;
use Spatie\CalendarLinks\Link;

/**
 * @see https://icalendar.org/RFC-Specifications/iCalendar-RFC-5545/
 */
class Ics implements Generator
{
    /** @var string {@see https://www.php.net/manual/en/function.date.php} */
    protected $dateFormat = 'Ymd';
    protected $dateTimeFormat = 'Ymd\THis\Z';

    /** {@inheritdoc} */
    public function generate(Link $link): string
    {
        $url = [
            'BEGIN:VCALENDAR',
            'PRODID:-//Google Inc//Google Calendar 70.9054//EN',
            'VERSION:2.0',
            'METHOD:PUBLISH',
            'BEGIN:VTIMEZONE',
            'TZID:Europe/London',
            'BEGIN:DAYLIGHT',
            'TZOFFSETFROM:+0000',
            'TZOFFSETTO:+0100',
            'TZNAME:BST',
            'DTSTART:19700329T010000',
            'RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU',
            'END:DAYLIGHT',
            'BEGIN:STANDARD',
            'TZOFFSETFROM:+0100',
            'TZOFFSETTO:+0000',
            'TZNAME:GMT',
            'DTSTART:19701025T020000',
            'RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU',
            'END:STANDARD',
            'END:VTIMEZONE',
            'BEGIN:VEVENT',
            'UID:'.$this->generateEventUid($link),
            'SUMMARY:'.$this->escapeString($link->title),
        ];

        $dateTimeFormat = $link->allDay ? $this->dateFormat : $this->dateTimeFormat;

        if ($link->allDay) {
            $url[] = 'DTSTART:'.$link->from->format($dateTimeFormat);
            $url[] = 'DURATION:P1D';
        } else {
            $url[] = 'DTSTART:'.$link->from->setTimezone(new DateTimeZone('UTC'))->format($dateTimeFormat);
            $url[] = 'DTEND:'.$link->to->setTimezone(new DateTimeZone('UTC'))->format($dateTimeFormat);
            $url[] = 'DTSTAMP:'.(new \DateTime())->setTimezone(new DateTimeZone('UTC'))->format('Ymd\THis\Z');
        }

        if ($link->recurPeriod) {
            $recur = FormatRecurring::formatRecurPeriod($link->recurPeriod);
            if ($recur && $link->recurUntil) {
                $url[] = $recur.';UNTIL='.$link->recurUntil->format('Ymd');
            }
        }

        if ($link->description) {
            $url[] = 'DESCRIPTION:'.$this->escapeString($link->description);
        }
        if ($link->address) {
            $url[] = 'LOCATION:'.$this->escapeString($link->address);
        }

        $url[] = 'END:VEVENT';
        $url[] = 'END:VCALENDAR';
        $redirectLink = implode("\r\n", $url);

        return $redirectLink;
    }

    /** @see https://tools.ietf.org/html/rfc5545.html#section-3.3.11 */
    protected function escapeString(string $field): string
    {
        return addcslashes($field, "\r\n,;");
    }

    /** @see https://tools.ietf.org/html/rfc5545#section-3.8.4.7 */
    protected function generateEventUid(Link $link): string
    {
        return md5($link->from->format(\DateTime::ATOM).$link->to->format(\DateTime::ATOM).$link->title.$link->address);
    }
}
