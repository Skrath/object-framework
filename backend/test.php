<?php

include 'core/DataStorage.class.php';

$data = new DataContainer(
[
    'Name' => 'Steve',
    'Age' => 36,
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
var_dump($data->Age);
var_dump($data->Address->Street);

echo "\nset again\n";
// var_dump($data->SetName('Doug'));
var_dump($data->Name = 'Doug');
var_dump($data->Address->Street = '197 Not Real Blvd.');

echo "\nget again\n";
var_dump($data->Name);
var_dump($data->Address->Street);

// echo "\nupdate type\n";
// var_dump($data->Name()->setType('string'));

// echo "\nobject\n";
// var_dump($data);
