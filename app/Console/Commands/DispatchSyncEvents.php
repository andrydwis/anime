<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncEventsJob;

class DispatchSyncEvents extends Command
{
    protected $signature = 'sync:events';
    protected $description = 'Dispatch the job to sync events from the spreadsheet';

    public function handle()
    {
        SyncEventsJob::dispatch();
        $this->info('SyncEventsJob dispatched successfully!');
    }
}
