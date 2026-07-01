<?php
session_start();

$sess_id = session_id();
$sess_name = session_name();

$error = "";
$sessions_in_redis = 0;
$curr_sess_in_redis = false;
try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    $sess_keys = $redis->keys('PHPREDIS_SESSION:*');
    $curr_sess_in_redis = in_array("PHPREDIS_SESSION:$sess_id", $sess_keys);
    $sessions_in_redis = count($sess_keys);
} catch (Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Информация о сессии</title>
</head>
<body>
    <h1>Информация о сессии</h1>

    <dl>
        <dt>ID сессии:</dt> <dd><?= $sess_id ?></dd>
        <dt>Имя сессии:</dt> <dd><?= $sess_name ?></dd>
        <dt>Обработчик сессий:</dt> <dd><?= ini_get('session.save_handler') ?></dd>
        <dt>Путь сохранения сессий:</dt> <dd><?= ini_get('session.save_path') ?></dd>
        <dt>Подключено:</dt> <dd><?= $error ? "Нет" : "Да" ?></dd>
        <dt>Ошибка подключения:</dt> <dd><?= $error ?: "-" ?></dd>
        <dt>Всего сессий в Redis:</dt> <dd><?= $sessions_in_redis ?></dd>
        <dt>Текущая сессия в Redis:</dt> <dd><?= $curr_sess_in_redis ? "Да" : "Нет" ?></dd>
        <dt>Имя хоста:</dt> <dd><?= gethostname() ?></dd>
        <dt>IP сервера:</dt> <dd><?= $_SERVER['SERVER_ADDR'] ?></dd>
        <dt>PID:</dt> <dd><?= getmypid() ?></dd>
    </dl>
</body>
</html>
