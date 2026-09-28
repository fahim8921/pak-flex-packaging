<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PackagingEnquiry extends Mailable
{
    public function __construct(public array $enquiry) {}

    public function build()
    {
        $mail = $this->subject('PakFlex enquiry '.$this->enquiry['reference'])
            ->replyTo($this->enquiry['email'], $this->enquiry['name'])
            ->view('emails.enquiry');
        if (!empty($this->enquiry['artwork_path'])) {
            $mail->attachFromStorageDisk('local', $this->enquiry['artwork_path'], 'artwork.'.pathinfo($this->enquiry['artwork_path'], PATHINFO_EXTENSION));
        }
        return $mail;
    }
}
