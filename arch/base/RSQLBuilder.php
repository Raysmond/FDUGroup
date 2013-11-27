<?php
/**
 * SQL builder class file
 *
 * @author: Raysmond
 */

class RSQLBuilder
{

    private $dbConfig;

    private $table;

    private $operation;

    private $select = '*';

    private $from;

    private $joins;

    private $where;

    private $whereValues;

    private $order;

    private $limit;

    private $group;

    private $having;

    private $sql;

    private $data = array();


    const DEFAULT_LIMIT_OFFSET = 0;

    const DEFAULT_LIMIT_SIZE = 10;

    const DEFAULT_OPERATION = "SELECT";

    const DEFAULT_PRIMARY_KEY = 'id';

    const DEFAULT_ORDER_KEY = 'id';

    const DEFAULT_ORDER = 'DESC';

    public function __construct($dbConfig, $table)
    {

        return $this;
    }

    public function select($selects)
    {
        return $this;
    }

    public function joins($join)
    {
        return $this;
    }

    public function leftJoins($joins)
    {
        return $this;
    }

    public function rightJoins($joins)
    {
        return $this;
    }

    public function conditions($conditions)
    {
        return $this;
    }

    public function limit($limit,$offset)
    {
        return $this;
    }

    public function insert()
    {
        return $this;
    }

    public function update()
    {
        return $this;
    }

    public function delete()
    {
        return $this;
    }

    public function toSQL()
    {
        $sql = '';

        return $sql;
    }

}