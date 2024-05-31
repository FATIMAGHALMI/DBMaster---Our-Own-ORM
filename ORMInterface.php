<?php

interface ORMInterface {
    public function save();
    public function create();
    public  function createTable($table, array $columns);
    public static function read($table, $id);
    public function delete();
    public function update();
     public function setTable($table);
    public function setAttributes(array $attributes);
    public function getAttributes();
    public  function addColumns($table, array $newColumns) ;
    public  function deleteColumns($table, array $columns);
    public function dropTable($table);
    
}
?>
