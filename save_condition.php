<?php
/** @var $conn PDO */
require_once __DIR__ . "/config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rule_id = isset($_POST['rule_id']) ? (int)$_POST['rule_id'] : 0;
    $template_id = isset($_POST['template_id']) ? (int)$_POST['template_id'] : 0;
    $operator_id = isset($_POST['operator_id']) ? (int)$_POST['operator_id'] : 0;
    $value = isset($_POST['value']) ? $_POST['value'] : '';

    if (empty($rule_id) || empty($template_id) || empty($operator_id) || empty($value)) {
        die('Пожалуйста, заполните все поля.');
    }

    try {
        $stmt = $conn->prepare('INSERT INTO conditions (template_id, operator_id, value) VALUES (:template_id, :operator_id, :value)');

        $stmt->bindParam(':template_id', $template_id, PDO::PARAM_INT);
        $stmt->bindParam(':operator_id', $operator_id, PDO::PARAM_INT);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);

        $stmt->execute();

        $condition_id = $conn->lastInsertId();

        $stmt2 = $conn->prepare('INSERT INTO rules_conditions (rule_id, condition_id) VALUES (:rule_id, :condition_id)');

        $stmt2->bindParam(':rule_id', $rule_id, PDO::PARAM_INT);
        $stmt2->bindParam(':condition_id', $condition_id, PDO::PARAM_INT);

        $stmt2->execute();

        echo 'Условие успешно добавлено и связано с правилом!';
    } catch (PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
} else {
    echo 'Неверный запрос!';
}
?>
