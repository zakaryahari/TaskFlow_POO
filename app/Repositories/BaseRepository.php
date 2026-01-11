<?php

abstract class BaseRepository {

    private Database $conn ;

    public function __construct(){
        $this->db = Database::getInstance();
    }

    abstract function find(int $id) ;
    abstract function findAll() ;
    abstract function save(array $data) ;
    abstract function delete(int $id) ;
}

?>