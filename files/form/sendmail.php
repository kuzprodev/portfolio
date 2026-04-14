<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->SMTPAuth   = true;
$mail->setLanguage('ru', 'phpmailer/language/');
//$mail->SMTPDebug = 2; //ракоментировать чтоб увидеть все ошибки
$mail->Debugoutput = function ($str, $level) {
	$GLOBALS['status'][] = $str;
};


// Настройки вашей почты
// $mail->Host       = 'smtp.yandex.ru'; // SMTP сервера вашей почты

// https://support.google.com/accounts/answer/185833?hl=ru чтоб не кидало в спам необходимо получить пароли приложений
$mail->Host       = 'ssl://smtp.gmail.com'; // SMTP сервера вашей почты    настройка для других почт https://snipp.ru/php/smtp-phpmailer
$mail->Username   = 'kuzprodev'; // Логин на почте
$mail->Password   = 'jfnuzpmvxzxplqsr'; // Пароль на почте
$mail->SMTPSecure = 'ssl';
$mail->Port       = 465;
//От кого письмо
$mail->setFrom('kuzprodev@gmail.com', 'kuzprodev.com-forma');
//Кому отправить
$mail->addAddress('kuzprodev@gmail.com');
//Тема письма
$mail->Subject = 'Привет! Это "Me"';

//Рука
$hand = "Правая";
if ($_POST['hand'] == "left") {
	$hand = "Левая";
}

//Тело письма
$body = '<h1>Встречайте супер письмо!</h1>';

if (trim(!empty($_POST['name']))) {
	$body .= '<p><strong>Имя:</strong> ' . $_POST['name'] . '</p>';
}
if (trim(!empty($_POST['email']))) {
	$body .= '<p><strong>E-mail:</strong> ' . $_POST['email'] . '</p>';
}
if (trim(!empty($_POST['hand']))) {
	$body .= '<p><strong>Рука:</strong> ' . $hand . '</p>';
}
if (trim(!empty($_POST['age']))) {
	$body .= '<p><strong>Возраст:</strong> ' . $_POST['age'] . '</p>';
}

if (trim(!empty($_POST['message']))) {
	$body .= '<p><strong>Сообщение:</strong> ' . $_POST['message'] . '</p>';
}

//Прикрепить файл
if (!empty($_FILES['image']['tmp_name'])) {
	//путь загрузки файла
	$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; //папка всегда на уровне с sendmail.php должна быть
	//грузим файл
	if (copy($_FILES['image']['tmp_name'], $filePath)) {
		$fileAttach = $filePath;
		$body .= '<p><strong>Фото в приложении</strong>';
		$mail->addAttachment($fileAttach);
	}
}
$mail->isHTML(true);
$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
} else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
