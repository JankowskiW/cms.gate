<?php

use App\Controllers\SessionController;

class QueryBuilder
{
    protected $pdo;
    protected $query;
    protected $table = [];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function fetch()
    {
        $this->execute();
        return $this->query->fetchAll(PDO::FETCH_CLASS);
    }

    public function fetchColumn()
    {
        $this->execute();
        return $this->query->fetchAll(PDO::FETCH_COLUMN);
    }

    public function table($table) // przyjmuje tablice nazw tablic
    {
        $this->table = implode(', ', $table);
        return $this;
    }

    public function select($attributes = ["*"])
    {
        $attributes = implode(',', $attributes);
        $this->query = "SELECT {$attributes} FROM {$this->table}";
        return $this;
    }

    public function where($conditions, $logicalOperator = 0)
    {
        // $conditions ["a = b", "c = d"]
        // $logicalOperator łączy te operatory odpowiednim słowem
        $cond2query = "";
        if ($logicalOperator) {
            $operator = "OR";
        } else {
            $operator = "AND";
        }

        if (sizeof($conditions) > 1) {
            foreach ($conditions as $condition) {
                //$cond2query .= implode(' ', $condition).' '.$operator.' ';
                $cond2query .= $condition . ' ' . $operator . ' ';
            }
            $this->query .= ' WHERE ' . trim($cond2query, ' ' . $operator . ' ');
        } else {
            $cond2query = $conditions;
            $this->query .= ' WHERE ' . $cond2query[0];
        }

        return $this;
    }

    public function whereIn($attribute, $array)
    {

        $this->query .= " WHERE " . $attribute . " IN ('" . implode(',', $array) . "')";
        return $this;
    }

    public function count($attribute = "*")
    {
        // TRZEBA POPRAWIC TAK ZEBY BYLO UNIWERSALNE
        $this->query = "SELECT COUNT({$attribute}) FROM {$this->table}";
        return $this;
    }

    public function leftJoin($joinedTable, $leftKey, $rightKey)
    {
        $this->query .= " LEFT JOIN $joinedTable ON $leftKey=$rightKey";
        return $this;
    }

    public function insert($parameters, $getID = false, $idName = "id")
    {
        //insert into names (name) values (:name)
        $sql = sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
        } catch (Exception $e) {
            die(var_dump($e->getMessage()));
        }

    }

    public function update($column, $value)
    {
        $numOfAttributes = sizeof($column);
        if ($numOfAttributes == sizeof($value)) {
            $this->query = "UPDATE $this->table SET ";
            for ($i = 0; $i < $numOfAttributes; $i++) {
                $this->query .= "$column[$i]='$value[$i]'" . ', ';
            }
            $this->query = trim($this->query, ', ');
            return $this;
        } else {
            SessionController::setErrors("Nie udało się zaktualizować tabeli.");
            return $this;
        }

    }

    public function execute()
    {
        $this->query = $this->pdo->prepare($this->query);
        $this->query->execute();
    }

    public function delete()
    {
        $this->query = "DELETE FROM $this->table";
        return $this;
    }

}