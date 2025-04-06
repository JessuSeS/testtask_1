<?php
/** @var $conn PDO */
require_once __DIR__ . "/config/db.php";

$queryRules = $conn->query("SELECT id, name FROM rules");
$rules = $queryRules->fetchAll(PDO::FETCH_ASSOC);

$queryTemplates = $conn->query("SELECT id, name FROM conditions_templates");
$templates = $queryTemplates->fetchAll(PDO::FETCH_ASSOC);

$queryOperators = $conn->query("SELECT id, `key`, name FROM operators");
$operators = $queryOperators->fetchAll(PDO::FETCH_ASSOC);

require_once __DIR__ . "/views/conditions_form.php";

