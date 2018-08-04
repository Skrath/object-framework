<?php
$autoloader = require '../vendor/autoload.php';

use Core\DataContainer;

$data = new DataContainer(
[
    'Name' => 'Steve',
    'Age' => 36,
    'Fraction' => 3.14159,
    'Alive' => true,
    'Address' => [
        'Street' => '123 Fake Street',
        'State' => 'Vermont'
    ]
]
);

// echo "set\n";
// var_dump($data->Name = 'Steve');
// var_dump($data->Age = 36);
// var_dump($data->Address = [
//             'Street' => '123 Fake Street',
//             'State' => 'Vermont'
//         ]
//     );


echo "\nget\n";
// var_dump($data->getName());
// var_dump($data->getAge());

var_dump($data->Name);
var_dump($data->Alive);
var_dump($data->Age);
var_dump($data->Fraction);

// var_dump($data->Name());

// var_dump($data->Name);
// var_dump($data->Age);
// var_dump($data->Address->Street);

// echo "\nupdate type\n";
// // var_dump($data->Name()->setType('string'));
// var_dump($data->Alive()->setType('boolean'));

echo "\nset again\n";
// var_dump($data->SaveName('Doug'));
var_dump($data->Name = 45);
var_dump($data->Alive = 'beans');
var_dump($data->Age = 'donut');
var_dump($data->Fraction = false);

// var_dump($data->Name = 'Doug');
// var_dump($data->Address->Street = '197 Not Real Blvd.');

echo "\nget again\n";
// var_dump($data->getName());
// var_dump($data->getAge());
// var_dump($data->Alive);

var_dump($data->Name);
var_dump($data->Alive);
var_dump($data->Age);
var_dump($data->Fraction);

// var_dump($data->Address->Street);

// echo "\nobject\n";
// var_dump($data);
