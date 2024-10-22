<?php

namespace AnhNguyenz\jQueryQueryBuilderPhp;

/**
 * Standard {@link Evaluator}
 * @package AnhNguyenz\jQueryQueryBuilderPhp
 */
class StandardEvaluator extends Evaluator
{
    public function __construct($rules = [])
    {
        parent::__construct($rules);

        $this->setGroupConditionEvaluator('AND', function (array $group, array $data, array $results) {
            $groupResult = true;
            foreach ($results as $result) {
                $groupResult &= $result;
            }

            return (bool)$groupResult;
        });

        $this->setGroupConditionEvaluator('OR', function (array $group, array $data, array $results) {
            $groupResult = false;
            foreach ($results as $result) {
                $groupResult |= $result;
            }

            return (bool)$groupResult;
        });

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'equal',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue == $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_equal',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue != $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'in',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return in_array($dataValue, $ruleValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_in',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return !in_array($dataValue, $ruleValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'less',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue < $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'less_or_equal',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue <= $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'greater',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue > $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'greater_or_equal',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue >= $ruleValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'between',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $dataValue >= $ruleValue[0] && $dataValue <= $ruleValue[1];
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_between',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return !($dataValue >= $ruleValue[0] && $dataValue <= $ruleValue[1]);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'begins_with',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $ruleValue === substr($dataValue, 0, strlen($ruleValue));
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_begins_with',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $ruleValue !== substr($dataValue, 0, strlen($ruleValue));
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'contains',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return false !== strpos($dataValue, $ruleValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_contains',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return false === strpos($dataValue, $ruleValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'rule_contains_data',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return false !== strpos($ruleValue, $dataValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'rule_contains_no_data',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return false === strpos($ruleValue, $dataValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'ends_with',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $ruleValue === substr($dataValue, -strlen($ruleValue));
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'not_ends_with',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return $ruleValue !== substr($dataValue, -strlen($ruleValue));
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'is_empty',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return empty($dataValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'is_not_empty',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return !empty($dataValue);
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'is_null',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return null === $dataValue;
            }
        );

        $this->setRuleTypeOperatorEvaluator(
            '*',
            'is_not_null',
            function (array $rule, array $data, $ruleValue, $dataValue) {
                return null !== $dataValue;
            }
        );
    }
}
