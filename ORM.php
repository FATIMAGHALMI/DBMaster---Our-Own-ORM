<?php

require_once 'Database.php';
require_once 'ORMInterface.php';

class ORM implements ORMInterface {
    protected $table;
    protected $attributes = [];
    protected $columns = [];
    protected $columnDefinitions = [];


    public function setTable($table) {
        $this->table = $table;
    }


  
    public function setAttributes(array $attributes) {
        $this->attributes = $attributes;
    }


    public function setColumns(array $columns) {
        $this->columns = $columns;
        $this->columnDefinitions = $this->generateColumnDefinitions($columns);
        if (!empty($this->columnDefinitions)) {
            $this->createTable($this->table, $this->columnDefinitions);
        }
    }


    private function generateColumnDefinitions(array $columns) {
        $definitions = [];
        foreach ($columns as $column) {
            $type = 'VARCHAR(255)'; 

          
            if ($column === 'id') {
                $type = 'INT AUTO_INCREMENT PRIMARY KEY';
            } elseif (strpos($column, '_id') !== false) {
                $type = 'INT';
            } elseif (strpos($column, 'created_at') !== false || strpos($column, 'updated_at') !== false) {
                $type = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP' . ($column === 'updated_at' ? ' ON UPDATE CURRENT_TIMESTAMP' : '');
            } elseif (strpos($column, 'is_') === 0 || strpos($column, 'has_') === 0) {
                $type = 'BOOLEAN';
            }

            $definitions[] = "$column $type";
        }
        return $definitions;
    }



    public function save() {
        if (isset($this->attributes['id'])) {
            return $this->update();
        } else {
            return $this->create();
        }
    }



    public function create() {
        $db = Database::getInstance()->getConnection();
        $columns = implode(", ", array_keys($this->attributes));
        $placeholders = implode(", ", array_fill(0, count($this->attributes), '?'));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($sql);
        $result = $stmt->execute(array_values($this->attributes));
        if ($result) {
            $this->attributes['id'] = $db->lastInsertId();
        } else {
            print_r($stmt->errorInfo());
        }
        return $result;
    }



    public function delete() {
        $db = Database::getInstance()->getConnection();
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute([$this->attributes['id']]);
    }




    public function createTable($table, array $columnDefinitions) {
        $db = Database::getInstance()->getConnection();
        $columns_str = implode(", ", $columnDefinitions);

        if (empty($columns_str)) {
            throw new Exception("No columns provided for table creation");
        }
        $sql = "CREATE TABLE IF NOT EXISTS {$table} ($columns_str)";
        return $db->exec($sql);
    }




    public static function read($table, $id) {
        $db = Database::getInstance()->getConnection();
        $sql = "SELECT * FROM {$table} WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $instance = new static();
            $instance->setTable($table);
            $instance->setAttributes($result);
            return $instance;
        }
        return null;
    }




    public function update() {
        if (!isset($this->attributes['id'])) {
            throw new Exception("ID is required to update a record.");
        }
        $db = Database::getInstance()->getConnection();
        $columns = implode(" = ?, ", array_keys($this->attributes)) . " = ?";
        $values = array_values($this->attributes);
        $values[] = $this->attributes['id'];
        $sql = "UPDATE {$this->table} SET {$columns} WHERE id = ?";
        $stmt = $db->prepare($sql);
        return $stmt->execute($values);
    }




    public function getAttributes() {
        return $this->attributes;
    }





    public function addColumns($table, array $newColumns) {
        $db = Database::getInstance()->getConnection();
        $definitions = $this->generateColumnDefinitions($newColumns);
        $columns_str = implode(", ", array_map(fn($col) => "ADD COLUMN $col", $definitions));
        
        // Vérifier si la chaîne de colonnes est vide
        if (empty($columns_str)) {
            throw new Exception("No columns provided for adding to the table.");
        }
    
        $sql = "ALTER TABLE {$table} {$columns_str}";
        if ($sql !== false) {
            echo "Colonnes ajoutées avec succès à la table {$table}.";
        } else {
            echo "Échec de l'ajout des colonnes à la table {$table}.";
        }
        return $db->exec($sql);
    }
    




    public function deleteColumns($table, array $columns) {
        $db = Database::getInstance()->getConnection();
        $columns_str = implode(", ", array_map(fn($col) => "DROP COLUMN $col", $columns));
        $sql = "ALTER TABLE {$table} $columns_str";
        if ($sql !== false) {
            echo "Colonnes supprimées avec succès de la table {$table}.";
        } else {
            echo "Échec de la suppression des colonnes de la table {$table}.";
        }
        return $db->exec($sql);
    }
    


    
    public function dropTable($table) {
        $db = Database::getInstance()->getConnection();
        $sql = "DROP TABLE IF EXISTS {$table}";
        $result = $db->exec($sql);
        if ($result !== false) {
            echo "Table {$table} dropped successfully.<br>";
        } else {
            echo "Failed to drop table {$table}.";
        }
        return $result;
    }
    
    
}
?>
