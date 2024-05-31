<?php
require_once 'Database.php';
require_once 'Product.php';


// $user = new User();

// $user->addColumns('users', [
//     'email' 
// ]);


$product = new Product();

$product->addColumns('produits', [
    'description' 
]);

?>