# Generate add to calendar links for Google, iCal and other calendar systems with recurring events

[Forked from spatie/calendar-links](https://github.com/spatie/calendar-links)

Using this package you can generate links to add events to calendar systems. Here's a quick example:

```php
Link::create(
    'Birthday',
    DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 09:00'),
    DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 18:00')),
    false,
    'daily',
    DateTime::createFromFormat('Y-m-d', '2018-03-01')
)->google();
```

This will output: `https://calendar.google.com/calendar/render?action=TEMPLATE&text=Birthday&dates=20180201T090000/20180201T180000&recur=RRULE:FREQ=DAILY;UNTIL=20180301sprop=&sprop=name:`

If you follow that link (and are authenticated with Google) you'll see a screen to add the event to your calendar.

The package can also generate ics files that you can open in several email and calendar programs, including Microsoft Outlook, Google Calendar, and Apple Calendar.

**Recurring events do not work on Microsoft Outlook and have not been set up for Yahoo**.


## Usage

``` php
<?php
use Spatie\CalendarLinks\Link;

$from = DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 09:00');
$to = DateTime::createFromFormat('Y-m-d H:i', '2018-02-01 18:00');
$until = DateTime::createFromFormat('Y-m-d', '2018-03-01');

$link = Link::create('Sebastian\'s birthday', $from, $to, false, 'daily', $until)
    ->description('Cookies & cocktails!')
    ->address('Samberstraat 69D, 2060 Antwerpen');

// Generate a link to create an event on Google calendar
echo $link->google();

// Generate a link to create an event on Yahoo calendar
echo $link->yahoo();

// Generate a link to create an event on outlook.com calendar
echo $link->webOutlook();

// Generate a data uri for an ics file (for iCal & Outlook)
echo $link->ics();

// Generate a data uri using arbitrary generator:
echo $link->formatWith(new \Your\Generator());
```

> ⚠️ ICS download links don't work in IE and EdgeHTML-based Edge browsers, see [details](https://github.com/spatie/calendar-links/issues/71).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Postcardware

You're free to use this package (it's [MIT-licensed](LICENSE.md)), but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Samberstraat 69D, 2060 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).
## Credits

- [Sebastian De Deyne](https://github.com/sebastiandedeyne)
- [All Contributors](../../contributors)

## Support us

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

Does your business depend on our contributions? Reach out and support us on [Patreon](https://www.patreon.com/spatie). 
All pledges will be dedicated to allocating workforce on maintenance and new awesome stuff.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
