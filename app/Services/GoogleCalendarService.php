<?php

namespace App\Services;

use Google_Client;
use Google_Service_Calendar;

class GoogleCalendarService
{
    public function getClient()
    {
        $client = new Google_Client();
        
        $authConfig = env('GOOGLE_SERVICE_ACCOUNT_JSON');
        
        if ($authConfig) {
            \Log::debug('Google Calendar: Using service account JSON from environment variable.');
            // Strip any accidental slashes or hidden characters from environment variable
            $decoded = json_decode($authConfig, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('Google Calendar JSON Decode Error: ' . json_last_error_msg());
                throw new \Exception('Invalid JSON provided for Google Service Account.');
            }

            // Fix for escaped newlines in the private key from environment variables
            if (isset($decoded['private_key'])) {
                $decoded['private_key'] = str_replace('\\n', "\n", $decoded['private_key']);
            }
            
            $client->setAuthConfig($decoded);
        } else {
            $path = storage_path('app/room-464006-67a87aa68d1b.json');
            if (file_exists($path)) {
                $client->setAuthConfig($path);
            } else {
                throw new \Exception('Google Service Account credentials missing.');
            }
        }

        $client->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        return $client;
    }

    public function getCalendarEvents(string $calendarId, int $maxResults = 10)
    {
        try {
            $client = $this->getClient();
            $service = new Google_Service_Calendar($client);

            $events = $service->events->listEvents($calendarId, [
                'maxResults'   => $maxResults,
                'orderBy'      => 'startTime',
                'singleEvents' => true,
                'timeMin'      => now()->toRfc3339String(),
            ]);

            return $events->getItems();
        } catch (\Exception $e) {
            \Log::error('Google Calendar Service Exception: ' . $e->getMessage(), [
                'calendar_id' => $calendarId,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw or return empty based on preference. 
            // Better to re-throw for a 500 so we know it's failing, 
            // but the log will tell us WHY.
            throw $e;
        }
    }
}
?>