<?php

namespace Shield\Database;

class Table {
    protected $table;
    protected $connection;

    protected array $where = [];
    

    public function __construct($table){
        $this->table = $table;
        $this->connection = DatabaseConnection::getInstance()->connection;
    }

    public function get() {
        if (count($this->where) == 0) {
            return $this->connection->query("select * from $this->table")->fetchAll();
        }

        $condition = "";
        foreach($this->where as $column => $value) {
            $operation = $value[0];
            if ($column == array_key_last($this->where)) {
                $condition .= $column . " $operation :$column";
            }
            else {
                $condition .= $column . " $operation :$column" . ' AND ';
            }
        }

        $conditions = array_map(function($c) {
            return $c[1]; 
        }, $this->where);
        
        

        $query = $this->connection->prepare("select * from $this->table where $condition");
        $query->execute($conditions);
        return $query->fetchAll();
        
    }

    public function where(string $column, string $operation = '=', string $value) {
        $this->where[$column][0] = $operation; 
        $this->where[$column][1] = $value; 
        return $this;
    }

    public function find(int $rows) {
        return $this->connection->query("select * from $this->table limit $rows")->fetchAll();
    }
}