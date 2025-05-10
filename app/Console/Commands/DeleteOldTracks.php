<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Track;
use Carbon\Carbon;

class DeleteOldTracks extends Command
{
    // The name and signature of the console command.
    protected $signature = 'tracks:delete-old';

    // The console command description.
    protected $description = 'Delete track records older than a specified time';

    // Execute the console command.
    public function handle()
    {
        // Get the current date minus 30 days (you can adjust this as needed)
        $thresholdDate = Carbon::now()->subDays(30);

        // Delete records older than 30 days
        $deletedCount = Track::where('created_at', '<', $thresholdDate)->delete();

        // Output result to the console
        $this->info("Deleted {$deletedCount} track records that were older than 30 days.");
    }
}
