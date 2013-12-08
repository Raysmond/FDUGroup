<?php
/**
 * Base data model of the ActiveRecord pattern.
 *
 * @author Xiangyan Sun
 */

/**
 * _RModelQueryer
 * Continuous-passing style SQL query builder.
 */
class _RModelQueryer {
    private $model;
    private $query_where, $query_order;
    private $args_where;

    public function __construct($model)
    {
        $this->model = $model;
        $this->query_where = "";
        $this->args_where = array();
        $this->query_order = "";
    }

    private function _args()
    {
        return $this->args_where;
    }

    private function _select($suffix = "")
    {
        $model = $this->model;
        $stmt = RModel::getConnection()->prepare("SELECT * FROM ".Rays::app()->getDBPrefix().$model::$table." $this->query_where $this->query_order $suffix");
        $stmt->execute($this->_args());
        $rs = $stmt->fetchAll();
        $ret = array();
        foreach ($rs as $row) {
            $obj = new $model();
            foreach ($model::$mapping as $member => $db_member) {
                $obj->$member = $row[$db_member];
            }
            $ret[] = $obj;
        }
        return $ret;
    }

    /**
     * Do SQL query, return count of matching rows
     * @return Count of matching rows
     */
    public function count()
    {
        $model = $this->model;
        $stmt = RModel::getConnection()->prepare("SELECT COUNT(*) FROM ".Rays::app()->getDBPrefix().$model::$table." $this->query_where");
        $stmt->execute($this->_args());
        return $stmt->rowCount();
    }

    /**
     * Do SQL query, return first matching object
     * @return First object matching given query, if no objects are found, null is returned
     */
    public function first()
    {
        $ret = $this->_select("LIMIT 1");
        if (count($ret) == 0)
            return null;
        else
            return $ret[0];
    }

    /**
     * Do SQL query, return all matching objects in given row range
     * @return All objects matching given query which row id is in the given range, if no objects are found, a empty-sized array is returned
     */
    public function range($firstrow, $rowcount)
    {
        return $this->_select("LIMIT $firstrow, $rowcount");
    }

    /**
     * Do SQL query, return all matching objects
     * @return All objects matching given query, if no objects are found, a empty-sized array is returned
     */
    public function all()
    {
        return $this->_select();
    }

    /**
     * Do SQL query, delete all matching objects
     */
    public function delete()
    {
        $model = $this->model;
        $stmt = RModel::getConnection()->prepare("DELETE FROM ".Rays::app()->getDBPrefix().$model::$table." $this->query_where $this->query_order");
        $stmt->execute($this->_args());
    }

    /**
     * Add a custom where clause
     * @param string $constraint Custom where clause to add
     * @param string $args Arguments to pass to the clause
     * @return This object
     */
    public function where($constraint, $args = array())
    {
        if ($this->query_where == "") {
            $this->query_where = "WHERE ";
        }
        else {
            $this->query_where .= " AND ";
        }
        $this->query_where .= $constraint;
        if (is_array($args)) {
            $this->args_where = array_merge($this->args_where, $args);
        }
        else {
            $this->args_where[] = $args;
        }
        return $this;
    }

    private function _find($constraints)
    {
        $model = $this->model;
        $constraint = "";
        $args = array();
        for ($i = 0; $i < count($constraints); $i += 2) {
            if ($constraint != "") {
                $constraint .= " AND ";
            }
            $db_member = $model::$mapping[$constraints[$i]];
            $constraint .= "$db_member = ?";
            $args[] = $constraints[$i + 1];
        }
        return $this->where($constraint, $args);
    }

    /**
     * Add a simple matching constraint
     * find(member, value) : (member) == value
     * find(constraints) : constraints is an array of 2 * N values which consists of N constraints
     * @return This object
     */
    public function find($memberName, $memberValue = null)
    {
        if ($memberValue == null) {
            return $this->_find($memberName);
        }
        else {
            return $this->_find(array($memberName, $memberValue));
        }
    }

    /**
     * Add a like matching constraint
     * @param string $memberName Member to be matched
     * @param string $memberValue Value to be matched
     * @return This object
     */
    public function like($memberName, $memberValue)
    {
        $model = $this->model;
        $db_name = $model::$mapping[$memberName];
        return $this->where("$db_name LIKE ?", "%$memberValue%");
    }

    /**
     * Add a free-form order clause
     * @param string $order "asc" or "desc", case insensitive
     * @param string $expression An expression used for ordering
     * @return This object
     */
    public function order($order, $expression)
    {
        if ($this->query_order == "") {
            $this->query_order = "ORDER BY ";
        }
        else {
            $this->query_order .= ", ";
        }
        $this->query_order .= "($expression) $order";
        return $this;
    }

    /**
     * Add an ascending order clause
     * @param string $memberName Column namd for ordering
     * @return This object
     */
    public function order_asc($memberName)
    {
        $model = $this->model;
        return $this->order("ASC", $model::$mapping[$memberName]);
    }

    /**
     * Add a descending order clause
     * @param string $memberName Column name for ordering
     * @return This object
     */
    public function order_desc($memberName)
    {
        $model = $this->model;
        return $this->order("DESC", $model::$mapping[$memberName]);
    }
}

abstract class RModel {
    private static $connection = null;

    /**
     * Get PDO connection object
     * @return PDO connection object
     */
    public static function getConnection()
    {
        if (self::$connection == null) {
            $dbConfig = Rays::app()->getDbConfig();
            self::$connection = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['db_name']};charset={$dbConfig['charset']}", $dbConfig['user'], $dbConfig['password']);
        }
        return self::$connection;
    }

    public static function get($id)
    {
        $model = get_called_class();
        return (new _RModelQueryer(get_called_class()))->find($model::$primary_key, $id)->first();
    }

    public static function find($memberName = null, $memberValue = null)
    {
        if ($memberName == null)
            return new _RModelQueryer(get_called_class());
        return (new _RModelQueryer(get_called_class()))->find($memberName, $memberValue);
    }

    public static function where($constraint, $args = array())
    {
        return (new _RModelQueryer(get_called_class()))->where($constraint, $args);
    }

    /**
     * Save current object
     * @return Id as primary key in database.
     */
    public function save()
    {
        $model = get_called_class();
        /* Build SQL statement */
        $columns = "";
        $values = "";
        $delim = "";
        $primary_key = $model::$primary_key;
        if (isset($this->$primary_key)) {
            $primary_key = "";
        }
	    foreach ($model::$mapping as $member => $column) {
            if ($member != $primary_key) {
                $columns = "$columns$delim$column";
                $values = "$values$delim?";
                $delim = ", ";
            }
        }
        $sql = "REPLACE INTO ".Rays::app()->getDBPrefix().$model::$table." ($columns) VALUES ($values)";

        /* Now prepare SQL statement */
        $stmt = RModel::getConnection()->prepare($sql);
        $args = array();
        foreach ($model::$mapping as $member => $column) {
            if ($member != $primary_key) {
                $args[] = $this->$member;
            }
        }
        $stmt->execute($args);
        $primary_key = $model::$primary_key;
        if (!isset($this->$primary_key)) {
            $this->$primary_key = RModel::getConnection()->lastInsertId();
        }
        return $this->$primary_key;
    }

    /**
     * Delete this object in database. Note the members of this object is not altered.
     */
    public function delete()
    {
        $model = get_called_class();
        $primary_key = $model::$primary_key;
        $sql = "DELETE FROM ".Rays::app()->getDBPrefix().$model::$table." WHERE {$model::$mapping[$primary_key]} == $this->$primary_key";
        RModel::getConnection()->exec($sql);
    }
}
