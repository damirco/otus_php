<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Проверка парности скобок</title>
    <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <div class="container">
        <h1>Проверка парности скобок</h1>
        <?php if ( isset($result) ) { ?>
        <div class="result result-<?= $result['type'] ?>">
            <?= $result['message'] ?>
        </div>
        <?php } ?>
        <form action="check.php" method="post">
            <div>
                <?php if ( !isset($string) || !is_string($string) ) { $string = ""; } ?>
                <label for="string">Введите скобки:</label>
                <input type="text" name="string" id="string" value="<?= htmlspecialchars($string) ?>" />
            </div>
            <div>
                <button type="submit">Проверить</button>
            </div>
        </form>
    </div>
</body>
</html>
