<?php

namespace App\repository;

use PDO;

class OperatorRepository
{
    public function __construct(private readonly PDO $conn) { }

    public function getAvailableOperators(int $templateId)
    {
        $stmt = $this->conn->prepare("
            SELECT o.id, o.name
            FROM operators o
            JOIN available_operators ao ON o.id = ao.operator_id
            WHERE ao.condition_id = :template_id
        ");
        $stmt->execute([':template_id' => $templateId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
