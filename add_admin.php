<?php
/**
 * لمرة واحدة: إضافة أو تحديث مستخدم جدول admin لتسجيل الدخول للوحة.
 * بعد النجاح احذف هذا الملف من السيرفر ولا ترفعه إلى مستودع عام.
 */

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/dashboard/config.php';

$adminUsername = 'admins';
$adminPassword = 'Moas1285@2134';

$hash = password_hash($adminPassword, PASSWORD_DEFAULT);
if ($hash === false) {
    echo '<p>فشل تشفير كلمة المرور.</p>';
    exit;
}

try {
    $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare('SELECT `id` FROM `admin` WHERE `username` = :u LIMIT 1');
    $stmt->execute(['u' => $adminUsername]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $upd = $pdo->prepare(
            'UPDATE `admin` SET `password` = :p, `is_active` = 1 WHERE `username` = :u'
        );
        $upd->execute(['p' => $hash, 'u' => $adminUsername]);
        $msg = 'تم تحديث كلمة المرور للمستخدم الموجود <strong>admins</strong>.';
    } else {
        $ins = $pdo->prepare(
            'INSERT INTO `admin` (`username`, `password`, `full_name`, `email`, `is_active`)
             VALUES (:u, :p, :fn, NULL, 1)'
        );
        $ins->execute([
            'u' => $adminUsername,
            'p' => $hash,
            'fn' => 'المشرف',
        ]);
        $msg = 'تم إنشاء المستخدم <strong>admins</strong> بنجاح.';
    }

    echo '<!DOCTYPE html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><title>إضافة مشرف</title></head><body>';
    echo '<p style="color:green;">' . $msg . '</p>';
    echo '<p>يمكنك تسجيل الدخول باسم المستخدم: <code>admins</code></p>';
    echo '<p><strong>احذف ملف add_admin.php فوراً من الخادم.</strong></p>';
    echo '</body></html>';
} catch (PDOException $e) {
    echo '<p style="color:red;">خطأ: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<p>تأكد من تشغيل <code>install_database.php</code> أولاً لإنشاء جدول <code>admin</code>.</p>';
}
