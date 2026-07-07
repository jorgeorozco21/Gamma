<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('db:backup-aws')->dailyAt('4:00')->onOneServer()->withoutOverlapping();

Schedule::command('db:clear-old')->dailyAt('5:30')->withoutOverlapping();
