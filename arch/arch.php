<?php
//链接mysql
class DataConnector {
	private static $connection = null;
	
	public static function getConnection() {
		if (self::$connection == null) {
			self::$connection = mysql_connect("localhost","root","") or die(mysql_error());
			mysql_select_db("group") or die(mysql_error());
			mysql_query("set names utf8") or die(mysql_error());
		}
		return self::$connection;
	}
}

//数据
class Data {
	public $key, $table, $columns;

	public function init($options) {
		$this->key = $options["key"];
		$this->table = $options["table"];
		$this->columns = $options["columns"];
	}

	public function reset() {
		foreach ($this->columns as $objCol => $dbCol) {
			$this->$objCol = null;
		}
	}

	public function load($id = null) {
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
		}else{
			return null;
		}
	}

	public function find() {
		$result = array();
		$where = " where 1 = 1 ";
		foreach ($this->columns as $objCol => $dbCol) {
			if ($this->$objCol) {
				$where .= " and $dbCol = {$this->$objCol}";
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

//Tree
class Tree extends Data {
	public $pkey;

	public function init($options) {
		parent::init($options);
		$this->pkey = $options["pkey"];
	}

	public function parent() {
		$o = clone $this;
		$o->reset();
		$o->{$o->key}=$this->{$this->pkey};
		return $o->load();
	}

	public function children() {
		$o = clone $this;
		$o->reset();
		$o->{$o->pkey} = $this->{$this->key};
		return $o->find();
	}

	public function toRoot() {
		$result = array();
		$o = clone $this;
		do {
			$result[] = $o;
			$o = $o->parent();
			/*$o->($o->key) = $this->($this->pkey);
			$o->load();*/
		}while ($o);
		return array_reverse($result);
	}
}

/*
//Area
class Area extends Tree {
	public $id, $pid, $name;

	public function __construct() {
		$options = array(
			"key" => "id",
			"pkey" => "pid",
			"table" => "babel_area",
			"columns" => array(
				"id" => "area_id",
				"pid" => "area_pid",
				"name" => "area_title"
			)
		);
		parent::init($options);
	}

	public function ads() {
		$a = new Ad();
		$a->areaId = $this->id;
		return $a->find();
	}
}

//Ad
class Ad extends Data {
	public $user, $area, $category;
	public $userId, $categoryId, $areaId, $id, $name, $content;

	public function __construct() {
		$options =array(
			"key" => "id",
			"table" => "babel_topic",
			"columns" => array(
				"id" => "tpc_id",
				"name" =>"tpc_title",
				"content" => "tpc_content",
				"userId" => "tpc_uid",
				"areaId" => "tpc_area",
				"categoryId" => "tpc_pid"
			)
		);
		parent::init($options);
	}

	public function load($id = null) {
		parent::load($id);
		$this->category = new Category();
		$this->category->id = $this->categoryId;
		$this->area = new Area();
		$this->area->id = $this->areaId;
		$this->user = new User();
		$this->user->id = $this->userId;
	}

	public function comments() {
		$a = new Comment();
		$a->adId = $this->id;
		return $a->find();
	}
}*/
?>