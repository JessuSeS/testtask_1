<?php
/** @var $conn PDO */
require_once __DIR__ . "/config/db.php";

$hotelId = $_GET['hotel_id'] ?? 1;
$hotels = $conn->query('SELECT id, name FROM `hotels`')->fetchAll(\PDO::FETCH_ASSOC);
$data = [];

foreach ($conn->query('SELECT * FROM `agencies`') as $agency) {
    $rulesStmt = $conn->prepare('
        SELECT DISTINCT r.id, r.name, r.text_for_manager
        FROM rules r
        JOIN rules_conditions rc ON r.id = rc.rule_id
        JOIN conditions c ON rc.condition_id = c.id
        WHERE r.agency_id = :agencyId
    ');
    $rulesStmt->execute([':agencyId' => $agency['id']]);

    while ($rule = $rulesStmt->fetch(PDO::FETCH_ASSOC)) {
        $conditionsStmt = $conn->prepare('
            SELECT c.template_id, c.operator_id, c.value
            FROM conditions c
            WHERE c.id IN (
                SELECT condition_id
                FROM rules_conditions
                WHERE rule_id = :ruleId
            )
        ');
        $conditionsStmt->execute([':ruleId' => $rule['id']]);

        $isConditionsMet = true;

        while ($condition = $conditionsStmt->fetch(PDO::FETCH_ASSOC)) {
            $conditionTemplateStmt = $conn->prepare(
                'SELECT table_name, column_name FROM conditions_templates WHERE id = :templateId'
            );
            $conditionTemplateStmt->execute([':templateId' => $condition['template_id']]);
            $conditionTemplate = $conditionTemplateStmt->fetch();

            $operatorStmt = $conn->prepare(
                'SELECT `key` FROM operators WHERE id = :operatorId'
            );
            $operatorStmt->execute([':operatorId' => $condition['operator_id']]);
            $operator = $operatorStmt->fetchColumn();

            match ($operator) {
                'equal' => $operator = '=',
                'not_equal' => $operator = '!=',
                'over' => $operator = '>',
                'less' => $operator = '<',
            };

            $realValueStmt = $conn->prepare(
                "SELECT {$conditionTemplate['table_name']}.{$conditionTemplate['column_name']} 
                        FROM hotels
                        JOIN cities ON hotels.city_id = cities.id
                        JOIN countries ON cities.country_id = countries.id
                        LEFT JOIN hotel_agreements ON hotels.id = hotel_agreements.hotel_id
                        LEFT JOIN companies ON hotel_agreements.company_id = companies.id
                        LEFT JOIN agency_hotel_options ON hotels.id = agency_hotel_options.hotel_id
                        LEFT JOIN agencies ON agency_hotel_options.agency_id = agencies.id
                        WHERE hotels.id = :hotelId
                        AND {$conditionTemplate['table_name']}.{$conditionTemplate['column_name']} $operator :conditionValue"
            );
            $realValueStmt->execute([':hotelId' => $hotelId, ':conditionValue' => $condition['value']]);

            if ($realValueStmt->fetchColumn() === false) {
                $isConditionsMet = false;

                break;
            }
        }

        $data[$agency['name']][] = [
            'isConditionsMet' => $isConditionsMet,
            'rule' => $rule,
        ];
    }
}

require_once __DIR__ . "/views/agency_rules.php";
