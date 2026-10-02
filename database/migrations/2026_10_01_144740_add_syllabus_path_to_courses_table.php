<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // إضافة حقل syllabus_path لحفظ مسار ملف المنهج
            $table->string('syllabus_path')->nullable()->after('hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            // حذف الحقل في حال التراجع عن الهجرة
            $table->dropColumn('syllabus_path');
        });
    }
};