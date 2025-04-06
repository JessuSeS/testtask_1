<?php

namespace App\controller;

use App\Repository\RuleRepository;

class RuleController
{
    public function __construct(private readonly RuleRepository $ruleRepository) { }
    public function index()
    {
        require __DIR__ . "/../views/rules_form.php";
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Метод не разрешен";
            return;
        }

        $agencyId = $_POST['agency_id'] ?? null;
        $name = $_POST['name'] ?? null;
        $textForManager = $_POST['text_for_manager'] ?? null;

        if (!$agencyId || !$name || !$textForManager) {
            http_response_code(400);
            echo "Все поля обязательны";
            return;
        }

        $this->ruleRepository->saveRule($agencyId, $name, $textForManager);

        header("Location: /rules");
        exit;
    }
}
