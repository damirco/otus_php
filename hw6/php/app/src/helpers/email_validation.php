<?php
use Damirco\Emailcheck\EmailSet;

function checkEmails(string $string, string &$message = ""): string
{
    if ( !strlen($string) ) {
        $message = "Вы ничего не ввели.";
        return 'incorrect';
    }
    $message = "";
    $emails = preg_split('/\s+/u', $string);
    $emailSet = new EmailSet($emails);
    $result = $emailSet->check();
    if ( $result['invalid'] ) {
        $message .= "Невалидные email-адреса: " . implode(", ", $result['invalid']);
        return 'incorrect';
    }
    $message = "Все email-адреса являются валидными.";
    return 'correct';
}
