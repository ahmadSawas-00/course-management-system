<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Course;
use Carbon\Carbon;

class UpdateExpiredCourses extends Command
{
    // اسم الأمر الذي يمكن تشغيله عبر artisan
    protected $signature = 'courses:update-expired';

    // وصف الأمر
    protected $description = 'تحديث حالة الكورسات المنتهية إلى غير فعال تلقائياً';

    public function handle()
    {
        // افترضنا وجود حقل end_date في جدول الكورسات، أو اعتماداً على التواريخ المسجلة لديك
        $updatedCount = Course::where('status', 'active')
            ->where('end_date', '<', Carbon::now())
            ->update(['status' => 'inactive']);

        $this->info("تم تحديث حالة {$updatedCount} كورس منتهي بنجاح.");
    }
}