<?php

namespace AnhNguyenz\jQueryQueryBuilderPhp;

use Closure;
use Exception;

/**
 * Parse jQuery Query Builder JSON into Evaluate class
 * @package AnhNguyenz\jQueryQueryBuilderPhp
 */
class Evaluator
{
    /**
     * @var array
     */
    protected $rules = [];
    /**
     * @var array
     */
    protected $groupConditionEvaluators = [];
    /**
     * @var array
     */
    protected $ruleTypeOperatorEvaluators = [];

    public function __construct($rules = [])
    {
        $this->setRules($rules);
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array|string $rules
     * @return $this
     */
    public function setRules($rules)
    {
        if (is_string($rules)) {
            $rules = json_decode($rules, true);
        }
        $this->rules = $rules;

        return $this;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function evaluate(array $data)
    {
        if (!$this->getRules()) {
            return true;
        }

        if (!is_array($this->getRules())) {
            throw new Exception('Rules must be an array if not empty');
        }

        if (array_key_exists('rules', $this->getRules())) {
            // Evaluate as group
            return $this->evaluateGroup($this->getRules(), $data);
        }

        // Evaluate as rule
        return $this->evaluateRule($this->getRules(), $data);
    }

    /**
     * @return array
     */
    public function getGroupConditionEvaluators()
    {
        return $this->groupConditionEvaluators;
    }

    /**
     * @param array $evaluators
     * @return $this
     */
    public function setGroupConditionEvaluators(array $evaluators)
    {
        $this->groupConditionEvaluators = $evaluators;

        return $this;
    }

    /**
     * @param string $condition
     * @return Closure|null
     */
    public function getGroupConditionEvaluator($condition)
    {
        if ($this->hasGroupConditionEvaluator($condition)) {
            return $this->groupConditionEvaluators[$condition];
        }

        return null;
    }

    /**
     * @param string $condition
     * @return bool
     */
    public function hasGroupConditionEvaluator($condition)
    {
        return !empty($this->groupConditionEvaluators[$condition]);
    }

    /**
     * @param string $condition
     * @return $this
     */
    public function removeGroupConditionEvaluator($condition)
    {
        unset($this->groupConditionEvaluators[$condition]);

        return $this;
    }

    /**
     * @param string $condition
     * @param Closure $evaluator
     * @return $this
     */
    public function setGroupConditionEvaluator($condition, $evaluator)
    {
        $this->groupConditionEvaluators[$condition] = $evaluator;

        return $this;
    }

    /**
     * @return array
     */
    public function getRuleTypeOperatorEvaluators()
    {
        return $this->ruleTypeOperatorEvaluators;
    }

    /**
     * @param array $evaluators
     * @return $this
     */
    public function setRuleTypeOperatorEvaluators(array $evaluators)
    {
        $this->ruleTypeOperatorEvaluators = $evaluators;

        return $this;
    }

    /**
     * @param string $type
     * @param string $operator
     * @return Closure|null
     */
    public function getRuleTypeOperatorEvaluator($type, $operator)
    {
        if ($this->hasRuleTypeOperatorEvaluator($type, $operator)) {
            return $this->ruleTypeOperatorEvaluators[$type][$operator];
        } elseif ($this->hasRuleTypeOperatorEvaluator('*', $operator)) {
            return $this->ruleTypeOperatorEvaluators['*'][$operator];
        }

        return null;
    }

    /**
     * @param string $type
     * @param string $operator
     * @return bool
     */
    public function hasRuleTypeOperatorEvaluator($type, $operator)
    {
        return !empty($this->ruleTypeOperatorEvaluators[$type][$operator]);
    }

    /**
     * @param string $type
     * @param string $operator
     * @return $this
     */
    public function removeRuleTypeOperatorEvaluator($type, $operator)
    {
        unset($this->ruleTypeOperatorEvaluators[$type][$operator]);

        return $this;
    }

    /**
     * @param string $type
     * @param string $operator
     * @param Closure $evaluator
     * @return $this
     */
    public function setRuleTypeOperatorEvaluator($type, $operator, $evaluator)
    {
        $this->ruleTypeOperatorEvaluators[$type][$operator] = $evaluator;

        return $this;
    }

    /**
     * @param array $group
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function evaluateGroup(array $group, array $data)
    {
        $condition = empty($group['condition']) ? null : $group['condition'];
        $evaluator = $this->getGroupConditionEvaluator($condition);
        if (!$evaluator) {
            throw new Exception('Group condition evaluator must be set first');
        }

        $rules = empty($group['rules']) ? [] : $group['rules'];
        if (!is_array($rules)) {
            throw new Exception('Group rules must be an array');
        }
        $ruleResults = [];
        foreach ($rules as $rule) {
            if (!$rule) {
                continue;
            }

            if (!is_array($rule)) {
                throw new Exception('Rule must be an array if not empty');
            }

            if (array_key_exists('rules', $rule)) {
                // Evaluate as group
                $ruleResults[] = $this->evaluateGroup($rule, $data);
                continue;
            }

            // Evaluate as rule
            $ruleResults[] = $this->evaluateRule($rule, $data);
        }

        return $evaluator($group, $data, $ruleResults);
    }

    /**
     * Evaluate the given data based on the given rule
     * @param array $rule
     * @param array $data
     * @return bool
     * @throws Exception
     */
    protected function evaluateRule(array $rule, array $data)
    {
        $field = empty($rule['field']) ? null : $rule['field'];
        if (!$field) {
            throw new Exception('Rule field must not be empty');
        }

        $type = empty($rule['type']) ? null : $rule['type'];
        $operator = empty($rule['operator']) ? null : $rule['operator'];
        $evaluator = $this->getRuleTypeOperatorEvaluator($type, $operator);
        if (!$evaluator) {
            throw new Exception('Rule type and/or operator evaluator must be set first');
        }

        $ruleValue = empty($rule['value']) ? null : $rule['value'];
        $dataValue = empty($data[$field]) ? null : $data[$field];

        return $evaluator($rule, $data, $ruleValue, $dataValue);
    }
}
