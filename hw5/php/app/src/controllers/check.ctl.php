<?php
require_helper('brackets_validation');

$string = "";
$result = [];

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    http_response_code(405);
    header('Allow: POST');
    $result['type'] = 'error';
    $result['message'] = "Некорректный метод отправки данных.";
} else {
    $string = isset($_POST['string']) && is_string($_POST['string']) ? $_POST['string'] : "";
    $message = "";
    $result['type'] = checkString($string, $message);
    $result['message'] = $message;
    if ( $result['type'] !== 'correct' ) {
        http_response_code(400);
    }
}

render('index.phtml', ['string' => $string, 'result' => $result]);
