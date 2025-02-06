# jQuery Query Builder PHP
Unofficial PHP evaluator for [jQuery QueryBuilder](http://querybuilder.js.org/)

# Installing
```
composer require anhnguyenz/jquery-querybuilder-php
```

# Usage
## TL;DR Oneliner
```php
(new \AnhNguyenz\jQueryQueryBuilderPhp\StandardEvaluator($rules))->evaluate($data);
```

## Basic usage
```php
// Have a $rules JSON string from jQuery QueryBuilder
$rules = '{"condition":"AND","rules":[{"id":"price","field":"price","type":"double","input":"number","operator":"less","value":"10.25"},{"condition":"OR","rules":[{"id":"category","field":"category","type":"integer","input":"select","operator":"equal","value":"2"},{"id":"category","field":"category","type":"integer","input":"select","operator":"equal","value":"1"}]}],"valid":true}';

// Have a $data array to evaluate with the $rules
$data = [
    'price' => 1000,
    'category' => 'TEST',
];

// Step 1: Initialize evaluator with $rules
$evaluator = new \AnhNguyenz\jQueryQueryBuilderPhp\StandardEvaluator($rules);
// OR
$evaluator = new \AnhNguyenz\jQueryQueryBuilderPhp\StandardEvaluator();
$evaluator->setRules($rules);

// Step 2: Use it to evaluate your $data array
$result = $evaluator->evaluate($data);

// Step 3: PROFIT!!!! .
var_dump($result);
```

# Support
Please [open an issue](https://github.com/AnhNguyenz/jquery-querybuilder-php-master/issues) for support.

# Contributing
This project uses [PSR-2](http://www.php-fig.org/psr/psr-2/) code style. This repository uses [gitflow](http://nvie.com/posts/a-successful-git-branching-model/) branching model.

Please fork this repository, and submit pull requests to `develop` branch.

# License
MIT License

Copyright &copy; 2017 [Nubeslab](https://nubeslab.com)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
