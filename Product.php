<?php

require_once 'Database.php';
require_once 'ORM.php';

// class User extends ORM {
//     protected $table = 'users';

//     public function __construct(array $attributes = []) {
//         $this->setTable($this->table);
//         $this->setAttributes($attributes);
//         $this->setColumns([
//             'id',
//             'name',
//             'prenom',
//             'age'
//         ]);
//     }
// }
   


class Product extends ORM {
    protected $table = 'produits';

    public function __construct(array $attributes = []) {
        $this->setTable($this->table);
        $this->setAttributes($attributes);
        $this->setColumns([
            'id',
            'name',
            'prix'
        ]);
    }
}

?>
