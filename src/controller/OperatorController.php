<?php

namespace App\controller;

use App\repository\OperatorRepository;

class OperatorController
{
    public function __construct(private OperatorRepository $operatorRepository) { }

    public function availableOperators()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $templateId = $data['template_id'] ?? null;

        if ($templateId === false) {
            echo json_encode(['error' => 'template_id не передан']);

            return;
        }

        $operators = $this->operatorRepository->getAvailableOperators($templateId);

        echo json_encode(['operators' => $operators]);
    }
}
