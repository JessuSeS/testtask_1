<?php

namespace App\repository;

use PDO;

class AgencyRepository
{
    public function __construct(private readonly PDO $conn) { }

    public function getAllAgencies(): array
    {
        return $this->conn->query('SELECT * FROM `agencies`')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRulesForAgency(int $agencyId): array
    {
        $stmt = $this->conn->prepare('
            SELECT DISTINCT r.id, r.name, r.text_for_manager
            FROM rules r
            JOIN rules_conditions rc ON r.id = rc.rule_id
            JOIN conditions c ON rc.condition_id = c.id
            WHERE r.agency_id = :agencyId
        ');
        $stmt->execute([':agencyId' => $agencyId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConditionsForRule(int $ruleId): array
    {
        $stmt = $this->conn->prepare('
            SELECT c.template_id, c.operator_id, c.value
            FROM conditions c
            WHERE c.id IN (
                SELECT condition_id
                FROM rules_conditions
                WHERE rule_id = :ruleId
            )
        ');
        $stmt->execute([':ruleId' => $ruleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConditionTemplate(int $templateId): array
    {
        $stmt = $this->conn->prepare('SELECT table_name, column_name FROM conditions_templates WHERE id = :templateId');
        $stmt->execute([':templateId' => $templateId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOperator(int $operatorId): string
    {
        $stmt = $this->conn->prepare('SELECT `key` FROM operators WHERE id = :operatorId');
        $stmt->execute([':operatorId' => $operatorId]);
        return $stmt->fetchColumn();
    }

    public function checkCondition(int $hotelId, array $conditionTemplate, string $operator, $value): bool
    {
        $sql = "
            SELECT {$conditionTemplate['table_name']}.{$conditionTemplate['column_name']}
            FROM hotels
            JOIN cities ON hotels.city_id = cities.id
            JOIN countries ON cities.country_id = countries.id
            LEFT JOIN hotel_agreements ON hotels.id = hotel_agreements.hotel_id
            LEFT JOIN companies ON hotel_agreements.company_id = companies.id
            LEFT JOIN agency_hotel_options ON hotels.id = agency_hotel_options.hotel_id
            LEFT JOIN agencies ON agency_hotel_options.agency_id = agencies.id
            WHERE hotels.id = :hotelId
            AND {$conditionTemplate['table_name']}.{$conditionTemplate['column_name']} $operator :conditionValue
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':hotelId' => $hotelId, ':conditionValue' => $value]);
        return $stmt->fetchColumn() !== false;
    }
}
