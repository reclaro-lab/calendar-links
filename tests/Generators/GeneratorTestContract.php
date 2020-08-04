<?php

namespace Spatie\CalendarLinks\Tests\Generators;

use Spatie\CalendarLinks\Generator;

/** @mixin \Spatie\CalendarLinks\Tests\TestCase */
trait GeneratorTestContract
{
    abstract protected function generator(): Generator;

    abstract protected function linkMethodName(): string;

    /** @test */
    public function it_has_a_valid_method_in_link_class()
    {
        $link = $this->createShortEventLink();

        $this->assertTrue(method_exists($link, $this->linkMethodName()));
        $this->assertSame($this->generator()->generate($link), $link->{$this->linkMethodName()}());
    }

    /** @test */
    public function it_can_generate_a_short_event_link()
    {
        $this->assertMatchesSnapshot(
            $this->generator()->generate($this->createShortEventLink())
        );

        $this->assertSame(
            $this->generator()->generate($this->createShortEventLink(false)),
            $this->generator()->generate($this->createShortEventLink(true))
        );
    }

    /** @test */
    public function it_can_generate_a_single_day_allday_event_link()
    {
        $this->assertMatchesSnapshot(
            $this->generator()->generate($this->createSingleDayAllDayEventLink())
        );

        $this->assertSame(
            $this->generator()->generate($this->createSingleDayAllDayEventLink(false)),
            $this->generator()->generate($this->createSingleDayAllDayEventLink(true))
        );
    }

    /** @test */
    public function it_can_generate_a_multiple_days_event_link()
    {
        $this->assertMatchesSnapshot(
            $this->generator()->generate($this->createMultipleDaysEventLink())
        );

        $this->assertSame(
            $this->generator()->generate($this->createMultipleDaysEventLink(false)),
            $this->generator()->generate($this->createMultipleDaysEventLink(true))
        );
    }

    /** @test */
    public function it_can_generate_a_multiple_days_event_link_with_allday_flag()
    {
        $this->assertMatchesSnapshot(
            $this->generator()->generate($this->createMultipleDaysAllDayEventLink())
        );

        $this->assertSame(
            $this->generator()->generate($this->createMultipleDaysAllDayEventLink(false)),
            $this->generator()->generate($this->createMultipleDaysAllDayEventLink(true))
        );
    }
}
