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
