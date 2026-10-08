<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Tahoma, Arial, sans-serif; background-color: #f8f9fa; padding: 20px; direction: rtl; text-align: right; }
        .card { background: #ffffff; padding: 25px; border-radius: 8px; max-width: 600px; margin: 0 auto; border: 1px solid #e9ecef; }
        .title { color: #0d6efd; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; }
    </style>
</head>
<body>
    <div class="card">
        <h2 class="title">مرحباً {{ $enrollment->student->name ?? 'عزيزي الطالب' }} 👋</h2>
        <p>تم تأكيد حجزك بنجاح في الكورس: <strong>{{ $enrollment->course->name ?? '' }}</strong>.</p>
        <p>نتمنى لك رحلة تعليمية ممتعة وموفقة!</p>
    </div>
</body>
</html>