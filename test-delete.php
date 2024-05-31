<?php

require_once 'Database.php';

require_once 'ORM.php';
require_once 'Product.php';

// $user = User::read('users', 1);
// if ($user) {
//     $user->delete();
//     echo "User deleted.";
// } else {
//     echo "User not found.";
// }


$Product = Product::read('produits', 1);
if ($Product) {
    $Product->delete();
    echo "Product deleted.";
} else {
    echo "Product not found.";
}

?>
