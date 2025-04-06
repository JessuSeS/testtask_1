<?php
/** @var $conn PDO */
require_once __DIR__ . "/config/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $agency_id = isset($_POST['agency_id']) ? (int)$_POST['agency_id'] : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $text_for_manager = isset($_POST['text_for_manager']) ? $_POST['text_for_manager'] : '';

    if (empty($agency_id) || empty($name) || empty($text_for_manager)) {
        die('Пожалуйста, заполните все поля.');
    }

    try {
        $stmt = $conn->prepare('INSERT INTO rules (agency_id, name, text_for_manager) VALUES (:agency_id, :name, :text_for_manager)');

        $stmt->bindParam(':agency_id', $agency_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':text_for_manager', $text_for_manager, PDO::PARAM_STR);

        $stmt->execute();

        echo 'Правило успешно добавлено!';
    } catch (PDOException $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
} else {
    echo 'Неверный запрос!';
}
?>
