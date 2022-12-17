<?php

namespace Shield\Database;

class Table {
    protected $table;
    protected $connection;

    protected array $select = [];

    protected array $where = [];
    

    public function __construct($table){
        $this->table = $table;
        $this->connection = DatabaseConnection::getInstance()->connection;
    }

    public function get() {
        $sql = $this->toSQL();

        return $this->connection->query($sql)->fetchAll(); 
    }

    public function select(...$columns) {
        $this->select = $columns;
        return $this;
    }

    public function where(string $column, string $operation = '=', string $value) {
        $this->where[$column] = $operation .= " $value"; 
        return $this;
    }

    public function find(int $rows) {
        return $this->connection->query("select * from $this->table limit $rows")->fetchAll();
    }

    private function toSQL() {
        $sql = "select ";

        if (count($this->select) > 0)
            $sql .= implode(', ', $this->select);
        else
            $sql .= '*';
        
        $sql .= " from $this->table";
        
        if (count($this->where) > 0) {
            $sql .= " where ";
            foreach($this->where as $column => $value) {
                
                $value = explode(' ', $value);
                $operator = $value[0];
                $condition = $this->connection->quote($value[1]);

                if ($column == array_key_last($this->where)) {
                    $sql .= $column . " $operator $condition ";
                }
                else {
                    $sql .= $column . " $operator $condition " . ' AND ';
                }
            }
        }
        return $sql;
    }
}