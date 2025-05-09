<?php

use Illuminate\Support\Facades\Schedule;

// Nagios command
$date = now()->format('Y-m-d');
Schedule::command('orders:check')
    ->everyMinute() // daily()
    ->sendOutputTo(storage_path("logs/nagios/{$date}-check-store-orders.log"));