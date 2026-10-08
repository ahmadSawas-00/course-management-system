# 📚 Course Booking Management System

نظام متكامل لإدارة وحجز الكورسات التدريبية مبني باستعمال **Laravel 13** و **Bootstrap 5 (RTL)**، مصمم لتقديم تجربة مستخدم سلسة وأداء عالي مع دعم الميزات الأمنية، الإشعارات الفورية، وتعدد اللغات.

---

## 🌟 أبرز الميزات والوظائف (Features)

* **🌐 دعم متعدد اللغات (I18n Localization):**
  * تبديل سلس بين العربية والإنجليزية مع ضبط اتجاه الصفحة تلقائياً (`RTL` / `LTR`).
  * استخدام Middleware مخصص لتثبيت وتتبع لغة التصفح.

* **📧 نظام الإشعارات الفورية بالبريد (Event-Driven Email System):**
  * إرسال إشعار بريدي تلقائيًا للطلبة عند تأكيد أو إنشاء عملية تسجيل جديدة عبر الأحداث والمستمعين (`EnrollmentCreated` & `SendEnrollmentNotification`).
  * تكامل كامل مع خوادم SMTP وبيئة الاختبار الأمنة عبر **Mailtrap**.
  * إمكانية تشغيل الإشعار عبر نظام الطوابير (`Queues`) لضمان عدم تأثر سرعة واستجابة الموقع.

* **⏰ جدولة المهام التلقائية (Automated Task Scheduling):**
  * فحص يومي آلي وجدولة تحديث حالات الكورسات والتسجيلات المنتهية عبر `Laravel Task Scheduler` وأوامر `Artisan` المخصصة.

* **📂 إدارة الملفات والمنهج الدراسي (File Storage Management):**
  * رفع وتخزين ملفات الـ PDF الخاصة بمنهج كل كورس بنظام هيكلي مُنظم (`storage/app/public/courses/{id}`).
  * ربط تلقائي لاستبدال الملفات القديمة وحذفها عند تعديل الكورس أو حذفه لضمان نظافة التخزين.

* **🛡️ حماية متقدمة للطلبات (Advanced Rate Limiting):**
  * تطبيق مخصص لـ `RateLimiter` يحد من محاولات الحجز العشوائية/المتكررة منعاً للـ Spam.
  * استجابة آلية بكود الحالة `HTTP 429 Too Many Requests` مع رسائل تنبيهية مخصصة.

* **🍪 تتبع تفضيلات المستخدم (Cookie Persistence):**
  * حفظ وتتبع "آخر كورس تم تصفحه" باستخدام Cookies دائمية تعيش لمدة 30 يوماً.
  * اقتراح استكمال التصفح للمستخدم عند العودة للوحة التحكم.

* **⚡ لوحة تحكم وإدارة الشاملة (CRUD):**
  * إدارة الكورسات، الطلاب، والتسجيلات مع حساب المقاعد المتبقية ديناميكياً.

---

## 🛠️ التقنيات المستخدمة (Tech Stack)

* **Backend:** PHP 8.4 / Laravel 13
* **Frontend:** Blade Templates, Bootstrap 5 (RTL), FontAwesome
* **Mail & Testing:** Mailtrap Sandbox, Laravel Mailables
* **Database:** MySQL
* **Tools & Middleware:** Custom Throttle Limiters, Custom Locale Middleware, Task Scheduler, Event Listeners, Storage Symlinks

---

## 🚀 طريقة التثبيت والتشغيل المحلي (Setup & Installation)

```bash
# 1. استنساخ المستودع
git clone [https://github.com/ahmadSawas-00/course-management-system.git](https://github.com/ahmadSawas-00/course-management-system.git)
cd course-management-system

# 2. تثبيت الحزم والمكتبات
composer install

# 3. إعداد ملف البيئة
cp .env.example .env
php artisan key:generate

# 4. ضبط إعدادات Mailtrap و الداتابيز في ملف .env
# MAIL_MAILER=smtp
# MAIL_HOST=sandbox.smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=your_username
# MAIL_PASSWORD=your_password

# 5. ضبط قاعدة البيانات وتنفيذ الـ Migrations
php artisan migrate

# 6. إنشاء الربط الوهمي لمجلد التخزين (Storage Link)
php artisan storage:link

# 7. تشغيل جدولة المهام (اختياري للتطوير)
php artisan schedule:work

# 8. تشغيل السيرفر المحلي
php artisan serve