<?php

namespace App\repository;

use PDO;

class RuleRepository
{
    public function __construct(private readonly PDO $conn) { }

    public function saveRule(int $agencyId, string $name, string $textForManager): void
    {
        $stmt = $this->conn->prepare("
            INSERT INTO rules (agency_id, name, text_for_manager) 
            VALUES (:agency_id, :name, :text_for_manager)
        ");
        $stmt->execute([
            ':agency_id' => $agencyId,
            ':name' => $name,
            ':text_for_manager' => $textForManager
        ]);
    }
}
