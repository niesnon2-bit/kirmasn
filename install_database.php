<?php
/**
 * يثبت بنية قاعدة البيانات من الملف:
 *   u144369246_dosudia(1) رخص.sql
 *
 * 1) في Railway → خدمة PHP → Variables: ALLOW_DB_INSTALL=true
 * 2) افتح: https://YOUR_APP.up.railway.app/install_database.php
 * 3) احذف المتغير والملف بعد الانتهاء.
 *
 * متغيرات اختيارية:
 * - IMPORT_SQL_DATA=true  → تنفيذ عبارات INSERT من الملف أيضاً (بيانات النسخ الاحتياطي)
 * - SQL_COLLATION_FALLBACK=true  → استبدال utf8mb4_uca1400_ai_ci بـ utf8mb4_unicode_ci إذا كان الخادم لا يدعم التجميعة (مثل بعض نسخ MySQL على Railway)
 */

header('Content-Type: text/html; charset=utf-8');

if (getenv('ALLOW_DB_INSTALL') !== 'true') {
    echo '<p>لتشغيل التثبيت: أضف <code>ALLOW_DB_INSTALL=true</code> في خدمة التطبيق، ثم أعد النشر وحدّث الصفحة.</p>';
    exit;
}

require_once __DIR__ . '/dashboard/config.php';

$sqlFile = __DIR__ . DIRECTORY_SEPARATOR . 'u144369246_dosudia(1) رخص.sql';

if (!is_readable($sqlFile)) {
    echo '<p>الملف غير موجود أو غير قابل للقراءة: <code>' . htmlspecialchars(basename($sqlFile)) . '</code></p>';
    exit;
}

$sql = file_get_contents($sqlFile);
if ($sql === false || $sql === '') {
    echo '<p>فشل قراءة ملف SQL.</p>';
    exit;
}

// إزالة بيانات INSERT ما لم يُطلب استيرادها (الهيكل فقط = كما في الملف من ناحية الجداول والفهارس والقيود)
if (getenv('IMPORT_SQL_DATA') !== 'true') {
    $sql = preg_replace('/INSERT INTO[\s\S]*?;\s*\n/', '', $sql);
}

// تجميعة MariaDB قد لا تتوفر على MySQL 8 — بديل اختياري
if (getenv('SQL_COLLATION_FALLBACK') === 'true') {
    $sql = str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_unicode_ci', $sql);
}

// يمكن إعادة التشغيل دون فشل "الجدول موجود"
$sql = preg_replace('/CREATE TABLE `/i', 'CREATE TABLE IF NOT EXISTS `', $sql);

$sql = str_replace(['START TRANSACTION;', 'COMMIT;'], '', $sql);

$mysqli = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
if (!$mysqli) {
    echo '<p>فشل الاتصال: ' . htmlspecialchars(mysqli_connect_error()) . '</p>';
    exit;
}

mysqli_set_charset($mysqli, 'utf8mb4');
mysqli_query($mysqli, 'SET FOREIGN_KEY_CHECKS=0');
mysqli_query($mysqli, 'SET SESSION sql_mode = "NO_AUTO_VALUE_ON_ZERO"');

$logOk = [];
$logErr = [];

function run_multi_sql(mysqli $mysqli, string $sql, array &$logOk, array &$logErr): bool
{
    if (!mysqli_multi_query($mysqli, $sql)) {
        $logErr[] = mysqli_error($mysqli) ?: 'multi_query failed';

        return false;
    }
    do {
        if ($result = mysqli_store_result($mysqli)) {
            mysqli_free_result($result);
        }
    } while (mysqli_next_result($mysqli));

    if (mysqli_errno($mysqli)) {
        $logErr[] = mysqli_error($mysqli);

        return false;
    }

    return true;
}

$ok = run_multi_sql($mysqli, $sql, $logOk, $logErr);

// إن فشل بسبب التجميعة، محاولة واحدة بالبديل
if (!$ok && getenv('SQL_COLLATION_FALLBACK') !== 'true'
    && (stripos(implode(' ', $logErr), 'uca1400') !== false
        || stripos(implode(' ', $logErr), 'Collation') !== false)) {
    $logErr = [];
    $sqlFallback = str_replace('utf8mb4_uca1400_ai_ci', 'utf8mb4_unicode_ci', file_get_contents($sqlFile));
    if (getenv('IMPORT_SQL_DATA') !== 'true') {
        $sqlFallback = preg_replace('/INSERT INTO[\s\S]*?;\s*\n/', '', $sqlFallback);
    }
    $sqlFallback = preg_replace('/CREATE TABLE `/i', 'CREATE TABLE IF NOT EXISTS `', $sqlFallback);
    $sqlFallback = str_replace(['START TRANSACTION;', 'COMMIT;'], '', $sqlFallback);
    $ok = run_multi_sql($mysqli, $sqlFallback, $logOk, $logErr);
    if ($ok) {
        $logOk[] = 'تم استخدام utf8mb4_unicode_ci بدل uca1400 تلقائياً (أضف SQL_COLLATION_FALLBACK=true في المرّة القادمة لتجنب هذه المحاولة).';
    }
}

mysqli_query($mysqli, 'SET FOREIGN_KEY_CHECKS=1');
mysqli_close($mysqli);

echo '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>تثبيت القاعدة من ملف SQL</title></head><body>';
echo '<h1>تثبيت من: u144369246_dosudia(1) رخص.sql</h1>';
echo '<p><strong>الاستيراد:</strong> ';
echo getenv('IMPORT_SQL_DATA') === 'true' ? 'هيكل + بيانات INSERT' : 'الهيكل فقط (بدون INSERT)';
echo '</p>';
echo '<p><strong>الخادم:</strong> ' . htmlspecialchars(DB_HOST) . ' — <strong>القاعدة:</strong> ' . htmlspecialchars(DB_NAME) . '</p>';

if ($ok) {
    echo '<p style="color:green;"><strong>اكتمل تنفيذ الملف.</strong></p>';
}

if (!empty($logErr)) {
    echo '<h2>أخطاء أو تحذيرات</h2><ul>';
    foreach ($logErr as $e) {
        echo '<li>' . htmlspecialchars($e) . '</li>';
    }
    echo '</ul>';
    echo '<p>إذا ظهر خطأ متعلق بـ <code>Duplicate key</code> أو <code>already exists</code> بعد تثبيت سابق، يمكنك إنشاء قاعدة جديدة فارغة أو إفراغ الجداول يدوياً ثم إعادة التشغيل.</p>';
} elseif ($ok) {
    echo '<p>لم تُبلَغ أخطاء من الخادم.</p>';
}

echo '<hr><p><strong>بعد التأكد:</strong> احذف <code>ALLOW_DB_INSTALL</code> وملف <code>install_database.php</code> من الإنتاج.</p>';
echo '<p>لاستيراد نفس البيانات الموجودة في الملف (النسخ الاحتياطي)، أضف <code>IMPORT_SQL_DATA=true</code> مؤقتاً ثم شغّل مرة واحدة (قد يتعارض مع بيانات موجودة).</p>';
echo '</body></html>';
