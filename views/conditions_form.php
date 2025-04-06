<?php
/** @var $rules array */
/** @var $templates array */
/** @var $operators array */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить условие</title>
</head>
<body>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>
<h2>Добавить условие</h2>
<form action="save_condition.php" method="post">
    <div>
        <label for="rule_id">ID правила</label>
        <select name="rule_id" id="rule_id" required>
            <option value="">Выберите правило</option>
            <?php foreach ($rules as $rule): ?>
                <option value="<?= $rule['id'] ?>"><?= htmlspecialchars($rule['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>

    <label for="template_id">ID шаблона условия:</label>
    <select id="template_id" name="template_id" required>
        <option value="">Выберите шаблон условия</option>
        <?php foreach ($templates as $template): ?>
            <option value="<?= $template['id'] ?>"><?= htmlspecialchars($template['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="operator_id">ID оператора:</label>
    <select id="operator_id" name="operator_id" required>
        <option value="">Выберите оператора</option>
        <?php foreach ($operators as $operator): ?>
            <option value="<?= $operator['id'] ?>"><?= htmlspecialchars($operator['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="value">Значение для сравнения:</label>
    <input type="text" id="value" name="value" required><br><br>

    <button type="submit">Сохранить</button>
</form>
</body>
</html>
