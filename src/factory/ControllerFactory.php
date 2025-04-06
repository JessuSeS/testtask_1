<?php

namespace App\factory;

use App\controller\AgencyController;
use App\controller\ConditionController;
use App\controller\OperatorController;
use App\controller\RuleController;
use App\repository\ConditionRepository;
use App\repository\HotelRepository;
use App\repository\AgencyRepository;
use App\repository\OperatorRepository;
use App\Repository\RuleRepository;
use App\service\RuleCheckService;
use PDO;

class ControllerFactory
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = require __DIR__ . "/../../config/db.php";
    }

    public function createAgencyController(): AgencyController
    {
        $hotelRepository = new HotelRepository($this->conn);
        $agencyRepository = new AgencyRepository($this->conn);
        $ruleCheckService = new RuleCheckService($agencyRepository);

        return new AgencyController($ruleCheckService, $hotelRepository);
    }

    public function createRuleController(): RuleController
    {
        return new RuleController(new RuleRepository($this->conn));
    }

    public function createConditionController(): ConditionController
    {
        return new ConditionController(new ConditionRepository($this->conn),);
    }

    public function createOperatorController(): OperatorController
    {
        return new OperatorController(new OperatorRepository($this->conn),);
    }
}
