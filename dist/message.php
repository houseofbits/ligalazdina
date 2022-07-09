<?php
header("Content-Type: application/json");

function errorResponse($str, $code)
{
    echo json_encode([
        'ok' => false,
        'code' => $code,
        'message' => $str
    ]);
    exit;
}

function isValidJSON($str)
{
    json_decode($str);
    return json_last_error() == JSON_ERROR_NONE;
}

$json_params = file_get_contents("php://input");

$data = null;

if (strlen($json_params) > 0 && isValidJSON($json_params)) {
    $data = json_decode($json_params);
}

if (empty($data)) {
    errorResponse("Invalid request data", 400);
}

$firstName = htmlspecialchars(stripslashes(trim($data->firstName)));
$lastName = htmlspecialchars(stripslashes(trim($data->lastName)));
$email = htmlspecialchars(stripslashes(trim($data->email)));
$message = htmlspecialchars(stripslashes(trim($data->message)));

if (!preg_match("/^[A-Za-z .'-]+$/", $firstName)) {
    errorResponse("Invalid firstName", 400);
}

if (!preg_match("/^[A-Za-z .'-]+$/", $lastName)) {
    errorResponse("Invalid lastName", 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    errorResponse("Invalid email", 400);
}

if (strlen($message) < 6) {
    errorResponse("Invalid message", 400);
}

$message = wordwrap($message, 70, "\r\n");

$to = 'contact@ligalazdina.com';
$subject = 'Message from ' . $firstName . ' ' . $lastName;
$headers = 'From: ' . $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$success = mail($to, $subject, $message, $headers);

$data = [
    'ok' => $success,
];

echo json_encode($data);

