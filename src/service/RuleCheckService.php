<?php

namespace App\service;

use App\enum\ComparisonOperatorEnum;
use App\repository\AgencyRepository;

final readonly class RuleCheckService
{

    public function __construct(
        private AgencyRepository $agencyRepository,
    ) { }

    public function checkRulesForAgency(int $hotelId): array
    {
        $data = [];
        foreach ($this->agencyRepository->getAllAgencies() as $agency) {
            $rules = $this->agencyRepository->getRulesForAgency($agency['id']);
            foreach ($rules as $rule) {
                $conditions = $this->agencyRepository->getConditionsForRule($rule['id']);
                $isConditionsMet = true;

                foreach ($conditions as $condition) {
                    $conditionTemplate = $this->agencyRepository->getConditionTemplate($condition['template_id']);
                    $operator = ComparisonOperatorEnum::fromString($this->agencyRepository->getOperator($condition['operator_id']));

                    if (!$this->agencyRepository->checkCondition($hotelId, $conditionTemplate, $operator->value, $condition['value'])) {
                        $isConditionsMet = false;
                        break;
                    }
                }

                $data[$agency['name']][] = [
                    'isConditionsMet' => $isConditionsMet,
                    'rule' => $rule,
                ];
            }
        }
        return $data;
    }
}
