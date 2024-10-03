<?php
$to = "paciobarc@gmail.com"; // Podaj swój adres e-mail
$subject = "Test e-mail";
$message = "To jest testowa wiadomość.";
$headers = "From: no-reply@parcNational.com" . "\r\n";

if(mail($to, $subject, $message, $headers)) {
    echo "E-mail został wysłany!";
} else {
    echo "Błąd podczas wysyłania e-maila.";
}
?>
