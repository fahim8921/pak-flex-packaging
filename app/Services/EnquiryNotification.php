<?php

namespace App\Services;

use App\Mail\PackagingEnquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EnquiryNotification
{
    public function send(array $enquiry): string
    {
        $recipient = config('pakflex.enquiry_email') ?: config('pakflex.email');
        $status = 'not_configured';
        // Only a real SMTP transport is considered delivery; log/array are not email delivery.
        if ($recipient && config('mail.default') === 'smtp') {
            try {
                Mail::to($recipient)->send(new PackagingEnquiry($enquiry));
                $status = 'sent';
            } catch (\Throwable $error) {
                report($error);
                $status = 'failed';
            }
        }
        $saved = Storage::disk('local')->put('enquiries/'.$enquiry['reference'].'/notification.json', json_encode([
            'status' => $status, 'attempted_at' => now()->toIso8601String(),
        ], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));
        if (!$saved) report(new \RuntimeException('Enquiry notification status could not be saved.'));
        return $status;
    }
}
