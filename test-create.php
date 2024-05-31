<?php

require_once 'Database.php';
require_once 'Product.php';


// $newUser = new User([
//     'name' => 'Ghalmi',
//     'prenom' => 'Fatima',
//     'age' => 12
// ]);

// $newUser->save();


$newProduct = new Product([
    'name' => 'Smartphone',
    'prix' => 700
  
]);

$newProduct->save();


?>
