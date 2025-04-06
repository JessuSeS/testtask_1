<?php
/** @var $data array */
/** @var $hotels array */
/** @var $hotelId int */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Проверка отелей</title>
</head>
<body>
<?php require_once __DIR__ . '/layouts/navbar.php'; ?>

<h2>Соблюдение правил</h2>
<select id="hotel_id">
    <?php foreach ($hotels as $hotel): ?>
        <option
            <?= $hotel['id'] == $hotelId ? 'selected' : '' ?>
            value="<?= $hotel['id'] ?>"
        >
            <?= $hotel['name'] ?>
        </option>
    <?php endforeach; ?>
</select>
<ul>
    <?php foreach ($data as $agency => $agencyData1): ?>
        <h3>
            <?= $agency ?>
        </h3>

        <?php foreach ($agencyData1 as $agencyData): ?>
            <li>
                <?php if ($agencyData['isConditionsMet'] === true): ?>
                    <span style="color: green">
                        <?= $agencyData['rule']['text_for_manager']?>
                    </span>
                <?php else: ?>
                    <span style="color: red">
                        Не подходит по правилу: <u> <?= $agencyData['rule']['name']?> </u>
                    </span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php endforeach; ?>
</ul>
</body>
</html>
<script>
    document.getElementById('hotel_id').onchange = function() {
        window.location = '?hotel_id=' + this.value;
    };
</script>
