<?php

namespace App\controller;

use App\repository\HotelRepository;
use App\service\RuleCheckService;

class AgencyController
{
    public function __construct(
        private readonly RuleCheckService $ruleCheckService,
        private readonly HotelRepository  $hotelRepository
    ) { }

    public function index(int $hotelId)
    {
        $hotels = $this->hotelRepository->getAllHotels();
        $data = $this->ruleCheckService->checkRulesForAgency($hotelId);

        require __DIR__ . "/../views/agency_rules.php";
    }
}
