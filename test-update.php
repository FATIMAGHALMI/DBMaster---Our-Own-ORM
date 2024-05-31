
<?php


require_once 'Database.php';
require_once 'Product.php'; 
require_once 'ORM.php';


// $user = new User();
// $user = User::read('users', 1);

// if ($user) {
//     $attributes = $user->getAttributes();
//     $attributes['name'] = 'salma';
//     $user->setAttributes($attributes);
//     $result = $user->update();
//     if ($result) {
//         echo "Mise à jour réussie.";
//     } else {
//         echo "Échec de la mise à jour.";
//     }
// } else {
//     echo "Utilisateur non trouvé.";
// }




$product = new Product();
$product = product::read('produits', 1);

if ($product) {   
    $attributes = $product->getAttributes();
    $attributes['prix'] = 200;
    $product->setAttributes($attributes);
    $result = $product->update();
    if ($result) {
        echo "Mise à jour réussie.";
    } else {
        echo "Échec de la mise à jour.";
    }
} else {
    echo "Utilisateur non trouvé.";
}





?>

