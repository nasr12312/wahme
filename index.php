<?php
// ابدأ الجلسة لتخزين حالة تسجيل الدخول
session_start();

// ###################################
// ##  غيّر هذا الكود إلى الكود السري الخاص بك  ##
// ###################################
$SECRET_CODE = "MySecret123";

// متغير لتحديد ما إذا كان يجب إظهار المحتوى المحمي
$is_loggedin = false;

// تحقق مما إذا كان المستخدم قد سجل دخوله بالفعل في هذه الجلسة
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $is_loggedin = true;
}

// تحقق مما إذا كان المستخدم يحاول تسجيل الدخول الآن (عبر إرسال النموذج)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['passcode']) && $_POST['passcode'] === $SECRET_CODE) {
        // الكود صحيح، قم بتسجيل دخوله في الجلسة
        $_SESSION['loggedin'] = true;
        $is_loggedin = true;
    } else {
        // الكود خاطئ، قم بتجهيز رسالة الخطأ
        $error_message = "الكود غير صحيح، حاول مرة أخرى.";
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة محمية</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; margin: 0; }
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            width: 90%;
            max-width: 350px;
        }
        .login-box h2 { margin-top: 0; }
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box; /* Ensures padding doesn't affect width */
        }
        .login-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
        }
        .error { color: #dc3545; margin-top: 10px; }
        .content { padding: 20px; }
    </style>
</head>
<body>

<?php if ($is_loggedin): ?>

    <div class="content">
        <h1>أهلاً بك في الصفحة المحمية!</h1>
        <p>هذا هو المحتوى السري الذي لا يظهر إلا بعد إدخال الكود الصحيح.</p>
        <p>يمكنك وضع كل عناصر موقعك هنا من صور ونصوص وفيديوهات.</p>
    </div>
    <?php else: ?>

    <div class="login-container">
        <div class="login-box">
            <form method="post" action="index.php">
                <h2>🔒 المحتوى محمي</h2>
                <p>الرجاء إدخال كود الدخول للمتابعة.</p>
                <input type="password" name="passcode" placeholder="أدخل الكود هنا" required>
                <button type="submit">دخــــول</button>
                <?php
                // إظهار رسالة الخطأ إذا كانت موجودة
                if (isset($error_message)) {
                    echo '<p class="error">' . $error_message . '</p>';
                }
                ?>
            </form>
        </div>
    </div>

<?php endif; ?>

</body>
</html>
