<?php

namespace App;

use App\factory\ControllerFactory;

class Router
{
    public function __construct(
        private readonly ControllerFactory $controllerFactory,
    ) { }

    public function dispatch(string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        match ($uri) {
            '/' => $this->controllerFactory->createAgencyController()->index($_GET['hotel_id'] ?? 1),
            '/rules' => $this->controllerFactory->createRuleController()->index(),
            '/conditions' => $this->controllerFactory->createConditionController()->index(),
            '/rules/save' => $this->controllerFactory->createRuleController()->save(),
            '/conditions/save' => $this->controllerFactory->createConditionController()->save(),
            '/operators/available' => $this->controllerFactory->createOperatorController()->availableOperators(),
            default => http_response_code(404),
        };
    }
}
