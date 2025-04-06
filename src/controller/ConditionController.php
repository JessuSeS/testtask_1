<?php

namespace App\controller;

use App\Repository\ConditionRepository;

class ConditionController
{
    public function __construct(
        private readonly ConditionRepository $conditionRepository,
    ) { }

    public function index(): void
    {
        $rules = $this->conditionRepository->getRules();
        $templates = $this->conditionRepository->getConditionTemplates();
        $operators = $this->conditionRepository->getOperators();
        $transformedArray = [];

        foreach ($this->conditionRepository->getAllAvailableConditionOperators() as $item) {
            $transformedArray[$item['id']][] = $item['name'];
        }

        require __DIR__ . '/../views/conditions_form.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Метод не разрешен";
            return;
        }

        $ruleId = $_POST['rule_id'] ?? null;
        $templateId = $_POST['template_id'] ?? null;
        $operatorId = $_POST['operator_id'] ?? null;
        $value = $_POST['value'] ?? null;

        if (!$ruleId || !$templateId || !$operatorId || !$value) {
            http_response_code(400);
            echo "Все поля обязательны";
            return;
        }

        $this->conditionRepository->saveCondition($ruleId, $templateId, $operatorId, $value);

        header("Location: /conditions");
        exit;
    }
}
