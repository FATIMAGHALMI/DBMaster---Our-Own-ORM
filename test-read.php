<?php

require_once 'Database.php';
require_once 'Product.php';
require_once 'ORM.php';


// $user = User::read('users', 1);

// if ($user) {
//     $attributes = $user->getAttributes();
//     echo '<h3> users</h3>';
//     foreach ($attributes as $columnName => $columnValue) {
//         echo $columnName . ": " . $columnValue . "<br>";
//     }
// } else {
//     echo "User not found.";
// }

$product = Product::read('produits', 3);

if ($product) {
    $attributes = $product->getAttributes();
    echo '<h3> products</h3>';
    foreach ($attributes as $columnName => $columnValue) {
        echo $columnName . ": " . $columnValue . "<br>";
    }
} else {
    echo "product not found.";
}


?>
