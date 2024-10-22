<?php

namespace Nubeslab\jQueryQueryBuilderPhpTests;

use Exception;
use Nubeslab\jQueryQueryBuilderPhp\StandardEvaluator;
use PHPUnit\Framework\TestCase;

class StandardEvaluatorTest extends TestCase
{
    /**
     * @dataProvider testDataProvider
     * @param string $rules The rules JSON
     * @param array $data The data
     * @param bool $expected
     */
    public function test($rules, array $data, $expected)
    {
        $evaluator = new StandardEvaluator();
        $evaluator->setRules($rules);
        $this->assertEquals($expected, $evaluator->evaluate($data));
    }

    public function testDataProvider()
    {
        // Operators
        $emptyData = [];
        $data1 = [
            'price' => 1000,
            'category' => 'TEST',
        ];
        $data2 = [
            'price' => 2000,
            'category' => 'test',
        ];

        // String operators
        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"equal","value":"TEST"}],"valid":true}';
        yield 'string equal 0' => [$rules, $emptyData, false];
        yield 'string equal 1' => [$rules, $data1, true];
        yield 'string equal 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"not_equal","value":"TEST"}],"valid":true}';
        yield 'string not_equal 0' => [$rules, $emptyData, true];
        yield 'string not_equal 1' => [$rules, $data1, false];
        yield 'string not_equal 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"in","value":["Test","TEST"]}],"valid":true}';
        yield 'string in 0' => [$rules, $emptyData, false];
        yield 'string in 1' => [$rules, $data1, true];
        yield 'string in 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"not_in","value":["Test","TEST"]}],"valid":true}';
        yield 'string not_in 0' => [$rules, $emptyData, true];
        yield 'string not_in 1' => [$rules, $data1, false];
        yield 'string not_in 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"begins_with","value":"TE"}],"valid":true}';
        yield 'string begins_with 0' => [$rules, $emptyData, false];
        yield 'string begins_with 1' => [$rules, $data1, true];
        yield 'string begins_with 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"not_begins_with","value":"TE"}],"valid":true}';
        yield 'string not_begins_with 0' => [$rules, $emptyData, true];
        yield 'string not_begins_with 1' => [$rules, $data1, false];
        yield 'string not_begins_with 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"contains","value":"ES"}],"valid":true}';
        yield 'string contains 0' => [$rules, $emptyData, false];
        yield 'string contains 1' => [$rules, $data1, true];
        yield 'string contains 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"not_contains","value":"ES"}],"valid":true}';
        yield 'string not_contains 0' => [$rules, $emptyData, true];
        yield 'string not_contains 1' => [$rules, $data1, false];
        yield 'string not_contains 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"ends_with","value":"ST"}],"valid":true}';
        yield 'string ends_with 0' => [$rules, $emptyData, false];
        yield 'string ends_with 1' => [$rules, $data1, true];
        yield 'string ends_with 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"not_ends_with","value":"ST"}],"valid":true}';
        yield 'string not_ends_with 0' => [$rules, $emptyData, true];
        yield 'string not_ends_with 1' => [$rules, $data1, false];
        yield 'string not_ends_with 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"is_empty","value":null}],"valid":true}';
        yield 'string is_empty 0' => [$rules, $emptyData, true];
        yield 'string is_empty 1' => [$rules, $data1, false];
        yield 'string is_empty 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"is_not_empty","value":null}],"valid":true}';
        yield 'string is_not_empty 0' => [$rules, $emptyData, false];
        yield 'string is_not_empty 1' => [$rules, $data1, true];
        yield 'string is_not_empty 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"is_null","value":null}],"valid":true}';
        yield 'string is_null 0' => [$rules, $emptyData, true];
        yield 'string is_null 1' => [$rules, $data1, false];
        yield 'string is_null 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"is_not_null","value":null}],"valid":true}';
        yield 'string is_not_null 0' => [$rules, $emptyData, false];
        yield 'string is_not_null 1' => [$rules, $data1, true];
        yield 'string is_not_null 2' => [$rules, $data2, true];

        // Double operators
        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"equal","value":"1000"}],"valid":true}';
        yield 'double equal 0' => [$rules, $emptyData, false];
        yield 'double equal 1' => [$rules, $data1, true];
        yield 'double equal 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"not_equal","value":"1000"}],"valid":true}';
        yield 'double not_equal 0' => [$rules, $emptyData, true];
        yield 'double not_equal 1' => [$rules, $data1, false];
        yield 'double not_equal 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"less","value":"1000"}],"valid":true}';
        yield 'double less 0' => [$rules, $emptyData, true];
        yield 'double less 1' => [$rules, $data1, false];
        yield 'double less 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"less_or_equal","value":"1000"}],"valid":true}';
        yield 'double less_or_equal 0' => [$rules, $emptyData, true];
        yield 'double less_or_equal 1' => [$rules, $data1, true];
        yield 'double less_or_equal 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"greater","value":"1000"}],"valid":true}';
        yield 'double greater 0' => [$rules, $emptyData, false];
        yield 'double greater 1' => [$rules, $data1, false];
        yield 'double greater 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"greater_or_equal","value":"1000"}],"valid":true}';
        yield 'double greater_or_equal 0' => [$rules, $emptyData, false];
        yield 'double greater_or_equal 1' => [$rules, $data1, true];
        yield 'double greater_or_equal 2' => [$rules, $data2, true];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"between","value":["900","1100"]}],"valid":true}';
        yield 'double between 0' => [$rules, $emptyData, false];
        yield 'double between 1' => [$rules, $data1, true];
        yield 'double between 2' => [$rules, $data2, false];

        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"not_between","value":["900","1100"]}],"valid":true}';
        yield 'double not_between 0' => [$rules, $emptyData, true];
        yield 'double not_between 1' => [$rules, $data1, false];
        yield 'double not_between 2' => [$rules, $data2, true];

        // Basic demo rules, stjälcuried from http://querybuilder.js.org/demo.html#basic
        $rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"text","operator":"less","value":"10.25"},{"condition":"OR","rules":[{"id":"category","field":"category","type":"integer","input":"select","operator":"equal","value":"2"},{"id":"category","field":"category","type":"integer","input":"select","operator":"equal","value":"1"}]}],"valid":true}';
        yield "basic demo rules with correct price, correct category" => [
            $rules,
            [
                'price' => 10,
                'category' => 1,
            ],
            true,
        ];
        yield "basic demo rules with correct price, wrong category" => [
            $rules,
            [
                'price' => 10,
                'category' => 3,
            ],
            false,
        ];
        yield "basic demo rules with wrong price, correct category" => [
            $rules,
            [
                'price' => 11,
                'category' => 1,
            ],
            false,
        ];
        yield "basic demo rules with wrong price, wrong category" => [
            $rules,
            [
                'price' => 11,
                'category' => 3,
            ],
            false,
        ];

        // Widgets demo rules, stjälcuried from http://querybuilder.js.org/demo.html#widgets
        $rules = '{"condition":"OR","rules":[{"id":"date","field":"date","type":"date","input":"text","operator":"equal","value":"1991/11/17"},{"id":"rate","field":"rate","type":"integer","input":"text","operator":"equal","value":22},{"id":"category","field":"category","type":"string","input":"text","operator":"equal","value":"38"},{"condition":"AND","rules":[{"id":"coord","field":"coord","type":"string","operator":"equal","value":"B.3"}]}],"valid":true}';
        yield "widgets demo rules with correct string date, correct rate, correct category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 22,
                'category' => 38,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, correct rate, correct category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 22,
                'category' => 38,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, correct rate, wrong category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 22,
                'category' => 39,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, correct rate, wrong category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 22,
                'category' => 39,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, wrong rate, correct category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 23,
                'category' => 38,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, wrong rate, correct category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 23,
                'category' => 38,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, wrong rate, wrong category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 23,
                'category' => 39,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with correct string date, wrong rate, wrong category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/17',
                'rate' => 23,
                'category' => 39,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, correct rate, correct category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 22,
                'category' => 38,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, correct rate, correct category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 22,
                'category' => 38,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, correct rate, wrong category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 22,
                'category' => 39,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, correct rate, wrong category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 22,
                'category' => 39,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, wrong rate, correct category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 23,
                'category' => 38,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, wrong rate, correct category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 23,
                'category' => 38,
                'coord' => 'A.1',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, wrong rate, wrong category, correct coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 23,
                'category' => 39,
                'coord' => 'B.3',
            ],
            true,
        ];
        yield "widgets demo rules with wrong string date, wrong rate, wrong category, wrong coord" => [
            $rules,
            [
                'date' => '1991/11/18',
                'rate' => 23,
                'category' => 39,
                'coord' => 'A.1',
            ],
            false,
        ];

        // Plugins demo rules, stjälcuried from http://querybuilder.js.org/demo.html#plugins
        $rules = '{"condition":"AND","rules":[{"id":"name","field":"name","type":"string","input":"text","operator":"equal","value":"Mistic"},{"condition":"OR","rules":[{"id":"category","field":"category","type":"integer","input":"checkbox","operator":"in","value":["1","2"]},{"id":"in_stock","field":"in_stock","type":"integer","input":"radio","operator":"equal","value":"0"}],"not":false}],"not":false,"valid":true}';
        yield "plugins demo rules with correct name, correct category, correct in_stock" => [
            $rules,
            [
                'name' => 'Mistic',
                'category' => 1,
                'in_stock' => 0,
            ],
            true,
        ];
        yield "plugins demo rules with correct name, correct category, wrong in_stock" => [
            $rules,
            [
                'name' => 'Mistic',
                'category' => 1,
                'in_stock' => 1,
            ],
            true,
        ];
        yield "plugins demo rules with correct name, wrong category, correct in_stock" => [
            $rules,
            [
                'name' => 'Mistic',
                'category' => 3,
                'in_stock' => 0,
            ],
            true,
        ];
        yield "plugins demo rules with correct name, wrong category, wrong in_stock" => [
            $rules,
            [
                'name' => 'Mistic',
                'category' => 3,
                'in_stock' => 1,
            ],
            false,
        ];
        yield "plugins demo rules with wrong name, correct category, correct in_stock" => [
            $rules,
            [
                'name' => 'WRONG',
                'category' => 1,
                'in_stock' => 0,
            ],
            false,
        ];
        yield "plugins demo rules with wrong name, correct category, wrong in_stock" => [
            $rules,
            [
                'name' => 'WRONG',
                'category' => 1,
                'in_stock' => 1,
            ],
            false,
        ];
        yield "plugins demo rules with wrong name, wrong category, correct in_stock" => [
            $rules,
            [
                'name' => 'WRONG',
                'category' => 3,
                'in_stock' => 0,
            ],
            false,
        ];
        yield "plugins demo rules with wrong name, wrong category, wrong in_stock" => [
            $rules,
            [
                'name' => 'WRONG',
                'category' => 3,
                'in_stock' => 1,
            ],
            false,
        ];
    }

    /**
     * @dataProvider testExceptionDataProvider
     * @expectedException Exception
     * @param string $rules The rules JSON
     * @param array $data The data
     * @expectedException
     */
    public function testException($rules, array $data)
    {
        $evaluator = new StandardEvaluator();
        $evaluator->setRules($rules);
        $evaluator->evaluate($data);
    }

    public function testExceptionDataProvider()
    {
        $emptyData = [];
        $data1 = [
            'price' => 1000,
            'category' => 'TEST',
        ];
        $data2 = [
            'price' => 2000,
            'category' => 'test',
        ];

        $rules = '{"condition":"AND","rules":"WRONG","valid":true}';
        yield 'wrong rules' => [$rules, $data1];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"","value":"TEST"}],"valid":true}';
        yield 'empty operator' => [$rules, $data1, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":null,"value":"TEST"}],"valid":true}';
        yield 'null operator' => [$rules, $data1, false];

        $rules = '{"condition":"AND","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"WRONG","value":"TEST"}],"valid":true}';
        yield 'wrong operator' => [$rules, $data1, false];

        $rules = '{"condition":"","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"equal","value":"TEST"}],"valid":true}';
        yield 'empty condition' => [$rules, $data1, false];

        $rules = '{"condition":null,"rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"equal","value":"TEST"}],"valid":true}';
        yield 'null condition' => [$rules, $data1, false];

        $rules = '{"condition":"WRONG","rules":[{"id":"category","field":"category","type":"string","input":"text","operator":"equal","value":"TEST"}],"valid":true}';
        yield 'wrong condition' => [$rules, $data1, false];
    }
}
