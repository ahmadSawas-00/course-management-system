<?php

namespace App\Listeners;

use App\Events\EnrollmentCreated;
use App\Mail\EnrollmentConfirmedMail;
use Illuminate\Support\Facades\Mail;

class SendEnrollmentNotification
{
    public function __construct()
    {
        //
    }

    public function handle(EnrollmentCreated $event): void
    {
        $student = $event->enrollment->student;

        if ($student && $student->email) {
            Mail::to($student->email)->send(new EnrollmentConfirmedMail($event->enrollment));
        }
    }
}