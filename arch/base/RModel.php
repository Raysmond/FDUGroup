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
    private $query_cond;
    private $prepare_list;

    public function __construct($model)
    {
        $this->model = $model;
        $this->query_cond = null;
        $this->prepare_list = array();
    }

    private function _select($suffix = "")
    {
        $stmt = RModel::getConnection()->prepare("SELECT * FROM [$this->model::$table] WHERE $this->query_cond $suffix");
        $stmt->execute($this->prepare_list);
        $rs = $stmt->fetchAll();
        $ret = array();
        foreach ($rs as $row) {
            $obj = new $this->model();
            foreach ($this->model::$mapping as $member => $db_member) {
                $obj->$member = $row[$db_member];
            }
            $ret[] = $obj;
        }
        return $ret;
    }

    /**
     * Do SQL query, return first matching object
     * @return First object matching given query, if no objects are found, null is returned
     */
    public function first()
    {
        $ret = _select("LIMIT 1");
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
        return _select("LIMIT $firstrow, $rowcount");
    }

    /**
     * Do SQL query, return all matching objects
     * @return All objects matching given query, if no objects are found, a empty-sized array is returned
     */
    public function all()
    {
        return _select();
    }

    /**
     * Do SQL query, delete all matching objects
     */
    public function delete()
    {
        $stmt = RModel::getConnection()->prepare("DELETE FROM [$this->model::$table] WHERE $this->query_cond");
        $stmt->execute($this->prepare_list);
    }

    private function _find($constraints)
    {
        foreach ($constraints as $member => $value) {
            if ($this->query_cond != null) {
                $this->query_cond .= " AND ";
            }
            $this->query_cond .= "$this->model::$mapping[$member] == ?";
            $this->prepare_list[] = $value;
        }
        return $this;
    }

    /**
     * Add a simple matching constraint
     * find(member, value) : (member) == value
     * find(constraints) : constraints is an array of 2 * N values which consists of N constraints
     * @return This object
     */
    public function where($memberName, $memberValue = null)
    {
        if ($memberValue == null) {
            return _find($memberName);
        }
        else {
            return _find(array($memberName, $memberValue));
        }
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
        if ($this->connection == null) {
            $connection = new PDO("mysql:host=$dbConfig['host'];dbname=$dbConfig['db_name'];charset=$dbConfig['charset']", $dbConfig['user'], $dbConfig['password']);
        }
        return $this->connection;
    }

    public static function where($memberName, $memberValue = null)
    {
        return (new _RModelQueryer(get_called_class()))->where($memberName, $memberValue);
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
	    for (self::$mapping as $member => $column) {
            if ($member != self::$primary_key) {
                $columns = "$columns$delim$column";
                $values = "$values$delim?";
                $delim = ", ";
            }
        }
        $sql = "INSERT OR UPDATE INTO [self::$table] ($columns) VALUES ($values)";

        /* Now prepare SQL statement */
        $stmt = RModel::getConnection()->prepare($sql);
        $i = 1;
        for (self::$mapping as $member => $column) {
            $stmt->bindParam($i++, $member);
        }
        $stmt->execute();
        $this->(self::$primary_key) = $stmt->lastInsertId();
        return $this->($this->primary_key);
    }

    /**
     * Delete this object in database. Note the members of this object is not altered.
     */
    public function delete()
    {
        $sql = "DELETE FROM [self::$table] WHERE self::$mapping[self::$primary_key] == $this->(self::$primary_key)";
        RModel::getConnection()->exec($sql);
    }
}
