<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('log:clear', function () {
    array_map('unlink', glob(storage_path('logs/*.log')));
    $this->comment('Logs cleared!');
})->describe('Clear all logs');
