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

    private function _auto_join_clause()
    {
        $model = $this->model;
        $clause = "";
        if (isset($model::$connection)) {
            foreach ($model::$connection as $member => $type) {
                $m = $type::$model;
                $modeltable = Rays::app()->getDBPrefix().$model::$table;
                $mtable = Rays::app()->getDBPrefix().$m::$table;
                $clause = "$clause LEFT JOIN $mtable ON $mtable.$m::$primary_key = $modeltable.$model::$mapping[$member]";
            }
        }
        return $clause;
    }

    private function _select($suffix = "")
    {
        $model = $this->model;
        $join = $this->_auto_join_clause();
        $stmt = RModel::getConnection()->prepare("SELECT * FROM ".Rays::app()->getDBPrefix().$model::$table." $this->query_where $this->query_order $join $suffix");
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
        $this->args_where = array_merge($this->args_where, $args);
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
            $member = $constraints[$i];
            $constraint .= "$model::$mapping[$member] == ?";
            $args[] = $constraints[$i + 1];
        }
        return where($constraint, $args);
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
            return _find($memberName);
        }
        else {
            return _find(array($memberName, $memberValue));
        }
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
        /* Build SQL statement */
        $columns = "";
        $values = "";
        $delim = "";
        $primary_key = self::$primary_key;
	    foreach (self::$mapping as $member => $column) {
            if ($member != $primary_key) {
                $columns = "$columns$delim$column";
                $values = "$values$delim?";
                $delim = ", ";
            }
        }
        $sql = "INSERT OR UPDATE INTO ".Rays::app()->getDBPrefix().self::$table." ($columns) VALUES ($values)";

        /* Now prepare SQL statement */
        $stmt = RModel::getConnection()->prepare($sql);
        $i = 1;
        foreach (self::$mapping as $member => $column) {
            $stmt->bindParam($i++, $member);
        }
        $stmt->execute();
        $this->$primary_key = $stmt->lastInsertId();
        return $this->$primary_key;
    }

    /**
     * Delete this object in database. Note the members of this object is not altered.
     */
    public function delete()
    {
        $primary_key = self::$primary_key;
        $sql = "DELETE FROM ".Rays::app()->getDBPrefix().self::$table." WHERE {self::$mapping[$primary_key]} == $this->$primary_key";
        RModel::getConnection()->exec($sql);
    }
}
