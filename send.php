<?php
$to      = 'contacts@koann.pro'; // ← Замените на ваш email
$subject = 'Заявка с сайта';
$from    = 'no-reply@' . $_SERVER['SERVER_NAME'];

$name  = trim($_POST['name']  ?? '');
$phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($name === '' || ($phone === '' && $email === '')) {
    http_response_code(400);
    echo 'Заполните обязательные поля.';
    exit;
}

$body = "Имя: $name\n";
$body .= $phone ? "Телефон: $phone\n" : '';
$body .= $email ? "E-mail: $email\n" : '';
foreach ($_POST as $k => $v) {
    if (!in_array($k, ['name','phone','email'])) {
        $body .= ucfirst($k).": $v\n";
    }
}

$headers = "From: $from\r\nReply-To: $from";
if (mail($to, $subject, $body, $headers)) {
    echo 'OK';
} else {
    http_response_code(500);
    echo 'Ошибка отправки';
}
?>