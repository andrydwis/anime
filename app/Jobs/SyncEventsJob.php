<?php

namespace App\Jobs;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncEventsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $sheetId = config('services.google_sheets.event_sheet_id');
        $gid = config('services.google_sheets.event_sheet_gid');
        $url = "https://docs.google.com/spreadsheets/d/$sheetId/gviz/tq?tqx=out:json&tq&gid=$gid";

        $response = Http::get($url);

        if ($response->failed()) {
            Log::error("Failed to fetch event data.");
            return;
        }

        // Extract JSON response
        $jsonData = str_replace(['/*O_o*/', 'google.visualization.Query.setResponse('], '', $response->body());
        $jsonData = substr($jsonData, 0, -2); // Remove trailing parenthesis
        $data = json_decode($jsonData, true);

        if (!isset($data['table']['rows'])) {
            Log::error("Invalid data format from Google Sheets.");
            return;
        }

        $events = [];
        $syncTime = Carbon::now();

        foreach ($data['table']['rows'] as $row) {
            // Extract name first
            $eventName = $row['c'][4]['v'] ?? null;
            if (!$eventName) {
                continue; // Skip inserting if name is missing
            }
        
            // Parse date
            $eventDate = null;
            if (isset($row['c'][0]['v'])) {
                $dateParts = explode(',', str_replace(['Date(', ')'], '', $row['c'][0]['v']));
                $eventDate = Carbon::create($dateParts[0], $dateParts[1] + 1, $dateParts[2])->toDateString();
            }
        
            // Parse time
            $eventTime = isset($row['c'][1]['f']) ? Carbon::createFromFormat('H:i', $row['c'][1]['f'])->format('H:i:s') : null;
        
            // Parse sync_time
            $syncTime = null;
            if (isset($row['c'][5]['f'])) {
                $syncTimeString = $row['c'][5]['f'];
                $syncTime = Carbon::createFromFormat('d-m-Y H:i', $syncTimeString);
            }
        
            // Add only valid events
            $events[] = [
                'name' => $eventName,
                'area' => $row['c'][3]['v'] ?? null,
                'date' => $eventDate,
                'time' => $eventTime,
                'location' => $row['c'][2]['v'] ?? null,
                'link' => $row['c'][6]['v'] ?? null,
                'sync_time' => $syncTime ?? Carbon::now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        

        if (empty($events)) {
            Log::info('No new events found.');
            return;
        }

        // Bulk process events
        $this->bulkSyncEvents($events);

        Log::info('Events synced successfully!');
    }

    /**
     * Sync events in bulk with batch inserts and updates
     */
    private function bulkSyncEvents(array $events)
    {
        $eventNames = array_column($events, 'name');
        $eventAreas = array_column($events, 'area');

        // Fetch existing events
        $existingEvents = Event::whereIn('name', $eventNames)
            ->whereIn('area', $eventAreas)
            ->get()
            ->keyBy(fn($event) => $event->name . '|' . $event->area);

        $insertData = [];
        $updateData = [];

        foreach ($events as $event) {
            $key = $event['name'] . '|' . $event['area'];

            if (isset($existingEvents[$key])) {
                $existingEvent = $existingEvents[$key];

                // Only update if sync_time is newer
                if ($existingEvent->sync_time < $event['sync_time']) {
                    $updateData[] = [
                        'id' => $existingEvent->id,
                        'date' => $event['date'],
                        'time' => $event['time'],
                        'location' => $event['location'],
                        'link' => $event['link'],
                        'sync_time' => $event['sync_time'],
                        'updated_at' => now(),
                    ];
                }
            } else {
                $insertData[] = $event;
            }
        }

        // Perform bulk inserts
        if (!empty($insertData)) {
            Event::insert($insertData);
        }

        // Perform bulk updates
        if (!empty($updateData)) {
            $this->bulkUpdateEvents($updateData);
        }
    }

    /**
     * Bulk update events using raw SQL
     */
    private function bulkUpdateEvents(array $updateData)
    {
        $table = (new Event())->getTable();
        $cases = [];
        $ids = [];

        foreach ($updateData as $update) {
            $cases[] = "WHEN id = {$update['id']} THEN '{$update['sync_time']}'";
            $ids[] = $update['id'];
        }

        $casesString = implode(' ', $cases);
        $idsString = implode(',', $ids);

        DB::statement("
            UPDATE $table
            SET sync_time = CASE $casesString END,
                updated_at = NOW()
            WHERE id IN ($idsString)
        ");
    }
}
