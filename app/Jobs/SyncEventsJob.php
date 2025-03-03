<?php

namespace App\Jobs;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

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
            \Log::error("Failed to fetch event data.");
            return;
        }

        // Extract JSON from Google's response
        $jsonData = str_replace(['/*O_o*/', 'google.visualization.Query.setResponse('], '', $response->body());

        // Remove the trailing closing parenthesis `)`
        $jsonData = substr($jsonData, 0, -2);

        // Decode JSON
        $data = json_decode($jsonData, true);

        //Clear Table



        if (!isset($data['table']['rows'])) {
            \Log::error("Invalid data format from Google Sheets.");
            return;
        }
        foreach ($data['table']['rows'] as $row) {

            $eventTimeString = null;
            $eventTime = null;

            //Format Date
            if (isset($row['c'][0]['v'])) {
                $eventDateString = $row['c'][0]['v']; // Example: Date(2025,1,22)
                $dateParts = str_replace(['Date(', ')'], '', $eventDateString);
                $dateParts = explode(',', $dateParts);  // Split the string into an array: [2025, 1, 22]
        
                // Adjust the month to be 1-indexed (JavaScript is 0-indexed)
                $year = $dateParts[0];
                $month = $dateParts[1] + 1;  // JavaScript month is 0-indexed, so add 1
                $day = $dateParts[2];

                $eventDate = Carbon::create($year, $month, $day)->toDateString();
            }

            //Format Time
            if (isset($row['c'][1]['f'])) {
                $eventTimeString = $row['c'][1]['f']; // Example: "09:00"
                $eventTime = Carbon::createFromFormat('H:i', $eventTimeString)->format('H:i:s');
            }

            $event = [
                'date' => $eventDate,
                'time' => $eventTime,
                'location' => isset($row['c'][2]['v']) ? $row['c'][2]['v'] : null,
                'area' => isset($row['c'][3]['v']) ? $row['c'][3]['v'] : null,
                'name' => isset($row['c'][4]['v']) ? $row['c'][4]['v'] : null,
                'link' => isset($row['c'][6]['v']) ? $row['c'][6]['v'] : null,
            ];
            
            if ($event['name']) {
                Event::updateOrCreate(
                    // Search criteria (use 'name' and 'date' if date is available)
                    [
                        'name' => $event['name'],
                        'area' => $event['area'],
                    ],
                    // Fields to update or create
                    [
                        'date' => $eventDate ?? null,
                        'location' => $event['location'],
                        'area' => $event['area'],
                        'link' => $event['link'],
                        'time' => $eventTime ?? null,  // Handle missing time
                    ]
                );
            }

        }

        \Log::info('Events synced successfully!');
    }
}
