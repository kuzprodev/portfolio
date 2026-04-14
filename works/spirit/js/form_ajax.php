<?php

// $my_mail = array("this_email1@gmail.com","this_email2@gmail.com");
// если необходимо на несколько почт отправлять

$my_mail = "konstantinkuznetsov.kh@gmail.com";
// если на одну почту

$siteName = "залитый для фриланса"; //название сайта с которого отправляется письмо, или пиши что хоч);

$name = trim($_POST["name"]);
$email = trim($_POST["email"]); //это неймы
$infa = trim($_POST["sms"]);
$message = "Имя: $name \nТелефон: $email \nСообщение: $infa";

$pagetitle = "Заявка с сайта \"$siteName\""; //тема письма, то что сверху в мыле;

// foreach ($my_mail as $my_mail) {
//     mail($my_mail, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $my_mail");
// }
// если на несколько почт

mail($my_mail, $pagetitle, $message, "Content-type: text/plain; charset=\"utf-8\"\n From: $my_mail");
//если на одну почту
