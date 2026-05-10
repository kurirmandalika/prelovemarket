<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('preloved:seed-samples', function () {
    $sampleEmails = [
        'admin@example.com',
        'user@example.com',
        'buyer@example.com',
    ];

    $sampleUsersCount = User::query()
        ->whereIn('email', $sampleEmails)
        ->count();

    if ($sampleUsersCount === count($sampleEmails)) {
        $this->info('Sample accounts already exist, skipping sample database seed.');

        return;
    }

    $this->info('Sample accounts missing, seeding sample accounts and products.');
    $this->call('db:seed', ['--force' => true]);
})->purpose('Seed sample Preloved Market accounts when they are missing');
