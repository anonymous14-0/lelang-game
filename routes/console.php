<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Command bawaan untuk menampilkan kutipan inspirasi di terminal.
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Menjadwalkan pengecekan pemenang lelang secara berkala.
Schedule::command('auction:check-winners')
    ->everyMinute();
