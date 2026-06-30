<?php

function bracketSum(string $string): int
{
    $brackets = 0;
    for ( $i = 0; $i < strlen($string); $i++ ) {
        if ( $string[$i] === '(' ) {
            $brackets++;
        } elseif ( $string[$i] === ')' ) {
            $brackets--;
        }
        if ( $brackets < 0 ) {
            return -1;
        }
    }
    return $brackets;
}

function checkString(string $string, string &$message = ""): string
{
    $string = preg_replace("~\\s+~u", "", $string);
    if ( !strlen($string) ) {
        $message = "Вы ничего не ввели.";
        return 'incorrect';
    }
    if ( !preg_match("~^[()]+$~u", $string) ) {
        $message = "Строка содержит некорректные символы. Разрешаются только круглые открывающие и закрывающие скобки.";
        return 'incorrect';
    }
    $brackets = bracketSum($string);
    if ( $brackets < 0 ) {
        $message = "Найдена закрывающая скобка без открывающей.";
        return 'incorrect';
    } else if ( $brackets > 0 ) {
        $message = "Некоторые скобки не закрыты.";
        return 'incorrect';
    }
    $message = "Скобки расставлены корректно.";
    return 'correct';
}

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

require_once __DIR__ . '/index.php';
