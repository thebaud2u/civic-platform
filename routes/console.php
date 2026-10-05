<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:update-recovery-balances')->dailyAt('01:00');
Schedule::command('app:update-day-off-balances')->monthly('00:00');
