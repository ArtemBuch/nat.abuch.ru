<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exceptions;
    use PHPMailer\PHPMailer\SMTP;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    // Настройки сервера 
                                 

    $mail->isSMTP();                                            // Отправка через SMTP 
    $mail->Host       = 'smtp.server.ru';                     // Настраиваем SMTP-сервер на отправку через 
    $mail->SMTPAuth   = true;                                    // Включить аутентификацию SMTP 
    $mail->Username   = 'name@server.ru';                     // Имя пользователя SMTP 
    $mail->Password   = 'passwd';                               // Пароль SMTP 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Включить неявное шифрование TLS 
    $mail->Port       = 465;                                    // TCP-порт для подключения; используйте 587, если вы установили `SMTPSecure = PHPMailer :: ENCRYPTION_STARTTLS`


    //Откого письмо
    $mail->setFrom('name@server.ru', 'name');
    //Кому отправить
    $mail->addAddress('name@server.ru');
    //Тема письма
    $mail->Subject = 'Новая заявка с сайта!';

    //Тело письма

    $body = '<h1>Поступила новая заявка с сайта!</h1>';
    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['tel']))){
        $body.='<p><strong>Телефон:</strong> '.$_POST['tel'].'</p>';
    }
    if(trim(!empty($_POST['message']))){
        $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
    }

    //Прикрепить файл
    if (!empty($_FILES['image']['tmp_name'])) {
        //путь загрузки файла
        $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
        //грузим файл
        if (copy($_FILES['image']['tmp_name'], $filePath)){
            $fileAttach = $filePath;
            $body.='<p><strong>Фото во вложении</strong></p>';
            $mail->addAttachment($fileAttach);
        }
    }

    $mail->Body = $body;

    //Отправляем
    if (!$mail->send()) {
        $message = "Ошибка {$mail->ErrorInfo}";
    } else {
        $message = 'Данные отправлены!';
    }

    $response = ['message' => $message];

    header('Content-Type: application/json');
    echo json_encode($response);
?>