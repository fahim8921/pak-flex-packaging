<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('pakflex:enquiries {--notify : Retry notifications not marked sent}', function () {
    $disk = \Illuminate\Support\Facades\Storage::disk('local');
    $rows = [];
    foreach ($disk->directories('enquiries') as $directory) {
        if (!$disk->exists($directory.'/enquiry.json')) continue;
        $record = json_decode($disk->get($directory.'/enquiry.json'), true, 512, JSON_THROW_ON_ERROR);
        $notification = $disk->exists($directory.'/notification.json') ? json_decode($disk->get($directory.'/notification.json'), true) : [];
        $status = $notification['status'] ?? 'pending';
        if ($this->option('notify') && $status !== 'sent') {
            $status = app(\App\Services\EnquiryNotification::class)->send($record);
        }
        $rows[] = [$record['reference'], $record['received_at'], $record['company'], $record['email'], $status];
    }
    $this->table(['Reference', 'Received', 'Company', 'Email', 'Notification'], $rows);
    if (!$rows) $this->info('No enquiries have been received.');
})->purpose('List private enquiries or retry pending sales email notifications');
