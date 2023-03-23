<?php

namespace Core\Table;

use App;

class Table
{
    protected $table;
    protected $db;

    public function __construct(
        protected $join = []
    ) {
        $this->db = App::getInstance()->getDb();
        if (!empty($join)) {
            foreach ($join as $cle => $value) {
                $this->setJoin($cle);
            }
        }
    }

    private function getQuestionMarks(array $array)
    {
        return implode(',', array_fill(0, count($array), '?'));
    }

    private function getCle(array $array)
    {
        return implode(',', $array);
    }

    private function getSet(array $array)
    {
        return implode(' = ?, ', $array) . ' = ?';
    }

    private function getWhere($array)
    {
        $params = [];
        foreach ($array as $cle => $value) {
            array_push($params, $cle);
        }
        return implode(' = ? AND ', $params) . ' = ?';
    }

    private function getValues($array)
    {
        $values = [];
        foreach ($array as $cle => $value) {
            array_push($values, $value);
        }
        return $values;
    }

    public function find($array)
    {
        return $this->db->query("SELECT " . $this->getCle($array) . " FROM " . $this->table . "", get_class($this), $this->join);
    }

    public function findBy($array, $attributes = null)
    {
        return $this->db->prepare("SELECT " . $this->getCle($array) . " FROM " . $this->table . " WHERE " . $this->getWhere($attributes) . "", $this->getValues($attributes), get_class($this));
    }

    public function findAll()
    {
        return $this->db->query("SELECT * FROM " . $this->table . "", get_class($this), [$this->join]);
    }

    public function findAllBy($attributes = null)
    {
        return $this->db->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->getWhere($attributes) . "", $this->getValues($attributes), get_class($this), $this->join, true);
    }

    public function findOne()
    {
        return $this->db->query("SELECT * FROM " . $this->table . " WHERE 1", get_class($this), true);
    }

    public function findOneBy($attributes = null)
    {
        return $this->db->prepare("SELECT * FROM " . $this->table . " WHERE " . $this->getWhere($attributes) . "", $this->getValues($attributes), get_class($this), $this->join, true);
    }

    public function update($structure, $attributes = null)
    {
        return $this->db->prepare("UPDATE " . $this->table . " SET " . $this->getSet($structure) . " WHERE id = ?", $attributes, get_class($this));
    }

    public function insert($structure, $attributes = null)
    {
        return $this->db->prepare("INSERT INTO " . $this->table . "(" . $this->getCle($structure) . ") VALUES(" . $this->getQuestionMarks($structure) . ")", $attributes, get_class($this));
    }

    public function delete($attributes = null)
    {
        $this->db->prepare("DELETE FROM " . $this->table . " WHERE id = ?;", [$attributes]);
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * Get the value of join
     */
    public function getJoin($table)
    {
        return $this->join[$table];
    }

    /**
     * Set the value of join
     *
     * @return  self
     */
    public function setJoin($join)
    {
        $Table = new $join();
        $this->join[$join] = $Table;
        return $this;
    }

    public function join($table)
    {
        $this->setJoin($table);
        $this->table = $this->table . " INNER JOIN " . $this->getJoin($table)->table . "";
        return $this;
    }

    public function on($condition)
    {
        $this->table = $this->table . " ON $condition";
        return $this;
    }

    public function getJoinValues($classnames, $name, $value)
    {
        foreach ($classnames as $class) {
            $method = "set" . ucfirst($name);
            $class->$method($value);
        }
    }

    public function __set($name, $value)
    {
        $this->getJoinValues($this->join, $name, $value);
    }
}
