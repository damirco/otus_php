<?php
echo "<h1>Проверка окружения</h1>";
echo "<h2>Текущая версия PHP: " . PHP_VERSION . "</h2>";
echo "<h3>Проверка подключения к сервисам:</h3>";

// Читаем переменные, которые Docker Compose пробросил в контейнер
$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT');
$dbName = getenv('DB_NAME');
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASSWORD');

// 1. Проверка PostgreSQL
try {
    // Формируем строку подключения динамически
    $dsn = "pgsql:host=$dbHost;port=$dbPort;dbname=$dbName";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    echo "✅ База данных PostgreSQL: Успешное подключение! (Данные авторизации скрыты в .env)<br>";
} catch (PDOException $e) {
    echo "❌ База данных PostgreSQL: Ошибка подключения: " . $e->getMessage() . "<br>";
}

// 2. Проверка Redis
try {
    $redis = new Redis();
    $redis->connect('redis', 6379);
    echo "✅ Redis: Успешное подключение!<br>";
} catch (Exception $e) {
    echo "❌ Redis: Ошибка: " . $e->getMessage() . "<br>";
}

// 3. Проверка Memcached
$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$stats = $memcached->getStats();
if (!empty($stats)) {
    echo "✅ Memcached: Успешное подключение!<br>";
} else {
    echo "❌ Memcached: Не удалось подключиться.<br>";
}
