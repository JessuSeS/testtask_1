<?php

namespace App\repository;

use PDO;

class ConditionRepository
{
    public function __construct(private readonly PDO $conn) { }

    public function getRules(): array
    {
        $stmt = $this->conn->query("SELECT id, name FROM rules");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConditionTemplates(): array
    {
        $stmt = $this->conn->query("SELECT id, name FROM conditions_templates");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOperators(): array
    {
        $stmt = $this->conn->query("SELECT id, `key`, name FROM operators");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saveCondition(int $ruleId, int $templateId, int $operatorId, string $value): void
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("
                INSERT INTO conditions (template_id, operator_id, value) 
                VALUES (:template_id, :operator_id, :value)
            ");
            $stmt->execute([
                ':template_id' => $templateId,
                ':operator_id' => $operatorId,
                ':value' => $value
            ]);

            $conditionId = $this->conn->lastInsertId();

            $stmt2 = $this->conn->prepare("
                INSERT INTO rules_conditions (rule_id, condition_id) 
                VALUES (:rule_id, :condition_id)
            ");
            $stmt2->execute([
                ':rule_id' => $ruleId,
                ':condition_id' => $conditionId
            ]);

            $this->conn->commit();
        } catch (\PDOException $e) {
            $this->conn->rollBack();
            throw new \Exception("Ошибка при сохранении условия: " . $e->getMessage());
        }
    }

    public function getAllAvailableConditionOperators()
    {
        $stmt = $this->conn->query(
            "SELECT 
                    conditions.`id`, 
                    operators.`id` as operator_id, 
                    operators.`key`,
                    operators.`name`
                    FROM conditions
                    JOIN available_operators ON available_operators.condition_id = conditions.`id`
                    JOIN operators ON operators.id = available_operators.`operator_id`
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
