<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить правило</title>
</head>
<body>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<h2>Добавить правило</h2>
<form action="save_rule.php" method="post">
    <label for="agency_id">ID агентства:</label>
    <input type="number" id="agency_id" name="agency_id" required><br><br>

    <label for="name">Название правила:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="text_for_manager">Текст для менеджера:</label>
    <textarea id="text_for_manager" name="text_for_manager" required></textarea><br><br>

    <button type="submit">Сохранить</button>
</form>
</body>
</html>
