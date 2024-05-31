<?php
require_once 'Database.php';
require_once 'Product.php';

// $user = new User();

// $user->deleteColumns('users', [
//     'email'
// ]);


$Product = new Product();

$Product->deleteColumns('produits', [
    'description'
]);


?>