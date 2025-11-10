<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Google\Client as GoogleClient;
use Illuminate\Support\Str;


class FcmService
{
    public static function notify(
        User $receiver,
        string $title = '',
        string $body = '',
        array $data,
    ) {
        if (!$receiver->fcm_token) {
            return errorResponse();
        }

        $projectId = config('services.fcm.project_id');

        $credentialsFilePath = Storage::path('firebase-auth.json');
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->fetchAccessTokenWithAssertion();
        $token = $client->getAccessToken();

        $headers = [
            'Authorization: Bearer ' . $token['access_token'],
            'Content-Type: application/json'
        ];

        $payload = json_encode([
            'message' => [
                'token' => $receiver->fcm_token,
                'notification' => [
                    'title' => $title ?? '',
                    'body' => $body ?? ''
                ],
                'data' => $data
            ]
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        if (app()->environment('local')) {
            curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        }

        $response = curl_exec($ch);
        // \Log::debug($response);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        // Check for cURL error
        // if ($error) {
        //     return false;
        // }

        // Check for HTTP success status code (2xx)
        // if ($httpCode >= 200 && $httpCode < 300) {

            // create notification record
            $receiver->notifications()->create([
                'id' => (string) Str::uuid(),
                'type' => $data['type'],
                'data' => array_merge(['title' => $title, 'body' => $body], $data),
            ]);

            return true;
        // }

        return true;
    }
    /**end of notify */
}