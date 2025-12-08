<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:3001'; // Your SMS service URL
    }

    public function sendSms($phoneNumber, $message)
    {
        try {
            $response = $this->client->post($this->baseUrl . '/send-sms', [
                'json' => [
                    'phone' => $phoneNumber,
                    'message' => $message
                ],
                'timeout' => 10
            ]);

            $result = json_decode($response->getBody(), true);
            
            if ($result['success']) {
                Log::info('SMS sent successfully', ['phone' => $phoneNumber]);
                return true;
            }
            
            return false;
        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendDocumentStatusUpdate($user, $documentRequest, $status)
    {
        $documentType = $documentRequest->documentType->name ?? 'Document';
        
        $messages = [
            'approved' => "Good day! Your request for {$documentType} has been APPROVED. Please wait for processing. - Barangay Office",
            'processing' => "Your {$documentType} is now being PROCESSED. You will be notified once ready. - Barangay Office",
            'ready' => "Your {$documentType} is now READY FOR PICKUP at the Barangay Office. Please bring valid ID. - Barangay Office",
            'completed' => "Thank you for claiming your {$documentType}. Have a great day! - Barangay Office",
            'rejected' => "We regret to inform you that your {$documentType} request has been REJECTED. Please contact the office for details. - Barangay Office"
        ];

        $message = $messages[$status] ?? "Your document request status has been updated to: {$status}";
        
        // Clean phone number (remove spaces, dashes)
        $phone = preg_replace('/[^0-9+]/', '', $user->phone);
        
        return $this->sendSms($phone, $message);
    }
}