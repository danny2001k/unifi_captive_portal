<?php
session_start();
if (!isset($_SESSION["ap"]) || !isset($_SESSION["id"])) {
    die("Essential parameters missing. Cannot proceed with registration.");
}
$config = require 'config.php';
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$db = new PDO($config['database']['dsn']);
$db->exec("CREATE TABLE IF NOT EXISTS users (email TEXT, code TEXT, validity INTEGER, expires_at DATETIME, ap TEXT, id TEXT, t TEXT, url TEXT, email_sent INTEGER DEFAULT 0)");

$email = $_POST['email'];
$code = generateRandomCode($config['code']['length']);

$ap = $_SESSION["ap"];
$id = $_SESSION["id"];
$t = $_SESSION["t"] ?? null;
$url = $_SESSION["url"] ?? null;
$expiresAt = date('Y-m-d H:i:s', time() + $config['code']['validity']);


// Insert into database
$stmt = $db->prepare("INSERT INTO users (email, code, validity, expires_at, ap, id, t, url) VALUES (?, ?, 1, ?, ?, ?, ?, ?)");
$stmt->execute([$email, $code, $expiresAt, $ap, $id, $t, $url]);

// Send email
$mail = new PHPMailer(true);

try {
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = $config['smtp']['debug'];
    $mail->isSMTP();
    $mail->Host = $config['smtp']['host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp']['username'];
    $mail->Password = $config['smtp']['password'];
    $mail->SMTPSecure = $config['smtp']['secure'];
    $mail->Port = $config['smtp']['port'];
    $mail->setFrom($config['smtp']['from']['email'], $config['smtp']['from']['name']);
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $config['smtp']['subject'];
    $mail->Body    = "Hello! Your access code is: <b>$code</b> and it's availaible for 8 hours.";
    $mail->send();
    $_SESSION['message'] = "Message has been sent";
    $mailSentSuccessfully = true;
} catch (Exception $e) {
    $_SESSION['message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

// Update the email_sent column in the database
$stmt = $db->prepare("UPDATE users SET email_sent = ? WHERE email = ? AND code = ?");
$stmt->execute([$mailSentSuccessfully ? 1 : 0, $email, $code]);


header("Location: verify.php"); // redirect to verification page
exit;

function generateRandomCode($length = 8) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomCode = '';
    for ($i = 0; $i < $length; $i++) {
        $randomCode .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomCode;
}
?>
