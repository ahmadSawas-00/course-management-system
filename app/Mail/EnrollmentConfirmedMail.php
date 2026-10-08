<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable; // 👈 تأكد من وجود هذا السطر
use Illuminate\Queue\SerializesModels;

class EnrollmentConfirmedMail extends Mailable // 👈 تأكد أنه يمتد من Mailable
{
    use Queueable, SerializesModels;

    public $enrollment;

    public function __construct($enrollment)
    {
        $this->enrollment = $enrollment;
    }

    public function build()
    {
        return $this->subject('تأكيد التسجيل في الدورة التدريبية')
                    ->view('emails.enrollment_confirmed');
    }
}