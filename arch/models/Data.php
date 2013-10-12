<?php

class Data
{
    public $key, $table, $columns;

    public function init($options)
    {
        $this->key = $options["key"];
        $this->table = $options["table"];
        $this->columns = $options["columns"];
    }

    public function reset()
    {
        foreach ($this->columns as $objCol => $dbCol) {
            $this->$objCol = null;
        }
    }

    public function load($id = null)
    {
        $key = $this->key;

        if ($id == null) {
            $id = $this->$key;
        }

        $sql = "select * from {$this->table} where {$this->columns[$key]} = $id";
        echo $sql;

        DataConnector::getConnection();
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        if ($row) {
            foreach ($this->columns as $objCol => $dbCol) {
                $this->$objCol = $row[$dbCol];
            }
            return $this;
        } else {
            return null;
        }
    }

    public function insert()
    {
        if ($this->key == null) {
            return;
        }
        $sql = 'insert into ' . $this->table . '( ';
        $values = " values ( ";
        $count = 1;
        foreach ($this->columns as $objCol => $dbCol) {
            $sql .= " {$dbCol}";
            $values .= "'{$this->$objCol}'";
            if ($count++ < sizeof($this->columns)) {
                $sql .= ",";
                $values .= ",";
            }
        }
        $sql .= ') ' . $values . ') ';

        //echo $sql;

        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());

    }

    public function update()
    {
        $sql = "update {$this->table} set ";
        $where = "";
        $count = 1;
        foreach ($this->columns as $objCol => $dbCol) {
            if (strcasecmp($this->key, $objCol) == 0) {
                $where .= " where {$dbCol} = '{$this->$objCol}'";
            }
            $sql .= "{$dbCol} = '{$this->$objCol}'";
            if ($count++ < sizeof($this->columns)) {
                $sql .= ", ";
            }
        }
        $sql .= $where;

        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
    }

    public function delete()
    {
        $key = $this->key;
        $sql = "delete from {$this->table} where {$this->columns[$this->key]} = {$this->$key}";
        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
    }


    public function find()
    {
        $result = array();
        $where = " where 1 = 1 ";
        foreach ($this->columns as $objCol => $dbCol) {
            if ($this->$objCol) {
                $where .= " and $dbCol = '{$this->$objCol}'";
            }
        }

        $sql = "select * from {$this->table} $where";
        DataConnector::getConnection();
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        while ($row) {
            $o = clone $this;
            foreach ($o->columns as $objCol => $dbCol) {
                $o->$objCol = $row[$dbCol];
            }
            $result[] = $o;
            $row = mysql_fetch_assoc($rs);
        }

        return $result;
    }
}