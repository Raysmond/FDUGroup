<?php

class Data
{
    public $key, $table, $columns;

    public function init($options)
    {
        $this->key = $options["key"];
        $this->table = Rays::app()->getDBPrefix().$options["table"];
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
        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
        return mysql_insert_id();

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

        //echo $sql;

        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
    }

    public function delete($assignment = array())
    {
        $key = $this->key;
        if (!count($assignment)) {  // no columns, then delete by key
            $sql = "delete from {$this->table} where {$this->columns[$this->key]} = {$this->$key}";
        } else {                    //delete by column numbers
            $sql = "delete from {$this->table} ";
            $where = " where 1=1 ";
            foreach ($assignment as $objCol => $value) {
                $where .= " and " . $this->columns[$objCol] ." = $value";
            }
            $sql .= $where;
        }

        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
    }


    public function find($limit_start=0,$limit_end=0,$order=array(),$like=array(), $assignment = array())
    {
        $result = array();
        $where = " where 1 = 1 ";
        foreach ($this->columns as $objCol => $dbCol) {
            if ($this->$objCol) {
                $where .= " and $dbCol = '{$this->$objCol}'";
            }
        }

        if(!empty($assignment))
        {
            foreach ($assignment as $objCol => $value) {
                if(is_array($value)){
                    $where .= " and " . $this->columns[$objCol] . " in (";
                    $count_value = count($value);
                    $count_cur = 0;
                    foreach($value as $val){
                        $where .= $val;
                        if($count_cur++<$count_value-1){
                            $where .= ',';
                        }
                        else $where .= ')';
                    }
                }
                else $where .= " and " . $this->columns[$objCol] ." = $value";
            }
        }

        if(!empty($like))
        {
            $where.=" and (";
            $first = true;
            foreach($like as $val)
            {
                if(isset($val['key'])&&isset($val['value']))
                {
                    if(!$first) $where.=" or ";
                    $where.= "  ".$val['key']." like '".$val['value']."' ";
                    $first = false;
                }
            }
            $where.=" ) ";
        }

        $sql = "select * from {$this->table} $where";

        if(count($order)>0&&isset($order['key'])&&isset($order['order'])){
            $sql.=" order by {$order['key']} {$order['order']}";
        }

        if($limit_start!=0||$limit_end!=0){
            $sql.=" LIMIT {$limit_start} , ".$limit_end;
        }

       // print_r($sql);

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


    public function count($like = array())
    {
        $result = array();
        $where = " where 1 = 1 ";
        foreach ($this->columns as $objCol => $dbCol) {
            if ($this->$objCol) {
                $where .= " and $dbCol = '{$this->$objCol}'";
            }
        }

        if(!empty($like))
        {
            $where.=" and (";
            $first = true;
            foreach($like as $val)
            {
                if(isset($val['key'])&&isset($val['value'])&&isset($this->columns[$val['key']]))
                {
                    if(!$first) $where.=" or ";
                    $where.= "  ".$this->columns[$val['key']]." like '%".$val['value']."%' ";
                    $first = false;
                }
            }
            $where.=" ) ";
        }

        $sql = "select count({$this->columns[$this->key]}) as count_result from {$this->table} $where";
        DataConnector::getConnection();
        $rs = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_assoc($rs);
        return $row['count_result'];
    }

    public static function db_query($sql){
        $result = array();
        DataConnector::getConnection();
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $result[] = $row;
        }
        return $result;
    }

    public static function executeSQL($sql)
    {
        DataConnector::getConnection();
        mysql_query($sql) or die(mysql_error());
    }

}