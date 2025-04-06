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
<form action="/conditions/save" method="post">
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
    <select id="template_id" name="template_id" required onchange="fetchOperatorsForTemplate(this.value)">
        <option value="">Выберите шаблон условия</option>
        <?php foreach ($templates as $template): ?>
            <option value="<?= $template['id'] ?>"><?= htmlspecialchars($template['name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label for="operator_id">ID оператора:</label>
    <select id="operator_id" name="operator_id" required disabled>
        <option value="">Выберите оператора</option>
    </select><br><br>

    <label for="value">Значение для сравнения:</label>
    <input type="text" id="value" name="value" required><br><br>

    <button type="submit">Сохранить</button>
</form>
</body>
</html>
<script>
    function fetchOperatorsForTemplate(templateId) {
        const operatorSelect = document.getElementById('operator_id');
        operatorSelect.disabled = true;

        operatorSelect.innerHTML = '<option value="">Выберите оператора</option>';

        if (!templateId) {
            return;
        }

        fetch('/operators/available', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ template_id: templateId })
        })
            .then(response => response.json())
            .then(data => {
                operatorSelect.disabled = false;

                if (data && data.operators) {
                    data.operators.forEach(operator => {
                        const option = document.createElement('option');
                        option.value = operator.id;
                        option.textContent = operator.name;
                        operatorSelect.appendChild(option);
                    });
                } else {
                    operatorSelect.innerHTML = '<option value="">Нет доступных операторов</option>';
                }
            })
            .catch(error => {
                console.error('Ошибка при получении операторов:', error);
                operatorSelect.disabled = true;
                operatorSelect.innerHTML = '<option value="">Ошибка загрузки</option>';
            });
    }
</script>
