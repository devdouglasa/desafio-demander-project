<?php

use App\Jobs\SyncDeputyExpensesJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Schedule::job(new SyncDeputyExpensesJob(), 'SyncDeputyExpensesJob', 'database')->daily();