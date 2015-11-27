<?php

class Libraries_Db_Mysql_Model
{
	public $data = array();

	/**
	 *
	 * @var string
	 */
	private $table_name = '';

	/**
	 *
	 * @var string
	 */
	private $table_id_field = 'id';

	/**
	 *
	 * @var Libraries_Db_Adapter
	 */
	protected $db = null;

	public function __construct($table_name, array $data = array())
	{
		$this->db = Libraries_Db_Factory::getDb();
		$this->table_name = $table_name;
		$this->data = $data;
	}

	/**
	 *
	 * @return boolean
	 */
	public function isEmpty()
	{
		if(!is_array($this->data))
		{
			return true;
		}
		
		return (!array_key_exists($this->table_id_field, $this->data) || empty($this->data[$this->table_id_field]) ? true : false);
	}

	/**
	 *
	 * @param string $value Unique value to search for
	 * @param string $field Name of field to search in
	 * @return Libraries_Db_Model
	 */
	public function load($value, $field = '')
	{
		$field = empty($field) ? $this->table_id_field : $field;

		$sql = "SELECT *
				FROM {$this->table_name}
				WHERE	{$field} = ? AND
						is_deleted = 0";

		$this->data = $this->db->fetchRow($sql, array($value));

		return $this;
	}

	/**
	 * @return Libraries_Db_Model
	 */
	public function save()
	{
		if(!is_array($this->data)) {
			return $this;
		}

		if(!$this->getTableIdValue())
		{
			return $this->insert();
		}
		else
		{
			return $this->update();
		}

		return $this;
	}

	/**
	 * @return Libraries_Db_Model
	 */
	private function insert()
	{
		$sql = "INSERT
				INTO {$this->table_name}
				SET " . $this->getDataForQuery();
		$this->db->execute($sql, $this->data);

		return $this->load($this->db->lastInsertId());
	}

	/**
	 * @return Libraries_Db_Model
	 */
	private function update()
	{
		$sql = "UPDATE {$this->table_name}
				SET " . $this->getDataForQuery() . "
				WHERE	{$this->getTableIdField()} = :{$this->getTableIdField()} AND
						is_deleted = 0";
		$this->db->execute($sql, $this->data);

		return $this->load($this->getTableIdValue());
	}

	/**
	 *
	 * @param string $where
	 * @param string $order
	 * @param int $offset
	 * @param int $limit
	 * @return Libraries_Db_Model_List
	 */
	public function search($where = array(), $order = array(), $offset = '', $limit = '', $debug = false)
	{
		$data = array();

		$sql = "SELECT *
				FROM	{$this->table_name}
				WHERE	is_deleted = 0";

		if($where)
		{
			foreach($where as $where_item)
			{
				if(!is_array($where_item[3]))
				{
					$sql .= ' ' . $where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' ?';
					$data[] = $where_item[3];
				}
				else
				{
					/*
					 * Ako se koristi IN, treba proslediti niz kao treci parametar.
					 * Onda ce taj niz biti zamenjen za ?, ?, ? i tako ce se odraditi prepare
					 */
					$sql .= ' ' . $where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' (';

					foreach($where_item[3] as $in_value_item)
					{
						$sql .= "?";
						if($in_value_item != end($where_item[3]))
						{
							$sql .= ',';
						}
						$data[] = $in_value_item;
					}

					$sql .= ')';
				}
			}
		}

		if($order)
		{
			$sql .= ' ORDER BY';
			foreach($order as $i => $order)
			{
				$sql .= ($i == 0 ? ' ' : ', ') . $order[0] . ' ' . $order[1];
			}
		}

		if($offset)
		{
			$sql .= ' LIMIT ' . $offset . ', ' . $limit;
		}
		else if($limit)
		{
			$sql .= ' LIMIT ' . $limit;
		}

		if($debug === true)
		{
			echo '<pre>'; print_r($data); echo '</pre>';
			echo '<pre>'; print_r($sql); echo '</pre>';
		}

		$model_name = get_class($this);
		$list = array();
		$results = $this->db->fetchAll($sql, $data);

		foreach($results as $row)
		{
			if($model_name == 'Libraries_Db_Mysql_Model')
			{
				$item = new $model_name($this->table_name, $row);
			}
			else
			{
				$item = new $model_name($row);
			}
			 
			$list[] = $item;
		}

		return $list;
	}

	/**
	 *
	 * @param string $where
	 * @return int
	 */
	public function searchCount(array $where = array(), $debug = false)
	{
		$sql = "SELECT COUNT({$this->getTableIdField()})
				FROM	{$this->table_name}
				WHERE	is_deleted = 0";

		$data = array();
		
		if($where)
		{
			foreach($where as $where_item)
			{
				if(!is_array($where_item[3]))
				{
					$sql .= ' ' . $where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' ?';
					$data[] = $where_item[3];
				}
				else
				{
					/*
					 * Ako se koristi IN, treba proslediti niz kao treci parametar.
					 * Onda ce taj niz biti zamenjen za ?, ?, ? i tako ce se odraditi prepare
					 */
					$sql .= ' ' . $where_item[0] . ' ' . $where_item[1] . ' ' . $where_item[2] . ' (';

					foreach($where_item[3] as $in_value_item)
					{
						$sql .= "?";
						if($in_value_item != end($where_item[3]))
						{
							$sql .= ',';
						}
						$data[] = $in_value_item;
					}

					$sql .= ')';
				}
			}
		}
		
		if($debug === true)
		{
			echo '<pre>'; print_r($data); echo '</pre>';
			echo '<pre>'; print_r($sql); echo '</pre>';
		}
		

		return $this->db->fetchColumn($sql, $data);
	}

	/**
	 *
	 * @return Libraries_Db_Model
	 */
	public function delete()
	{
		$this->is_deleted = 1;
		$this->save();

		return $this;
	}

	/**
	 * @param string $property Name of field to get
	 * @return mixed|null
	 */
	public function __get($property)
	{
		if(is_array($this->data) && array_key_exists($property, $this->data)) return $this->data[$property];
		return null;
	}

	/**
	 *
	 * @param string $property Name of field to set
	 * @param string $value Data to set
	 * @return Libraries_Db_Model
	 */
	public function __set($property, $value) {
		$this->data[$property] = $value;
		return $this;
	}
	
	/**
	 * 
	 * @param string $property
	 * @return bool
	 */
	public function __isset($property)
	{
		if(!is_array($this->data))
		{
			return false;
		}
		
		return array_key_exists($property, $this->data);
	}

	/**
	 *
	 * @return Ambigous <NULL, multitype:>
	 */
	public function getTableIdValue() {
		$table_id_field = $this->getTableIdField();
		return isset($this->data[$table_id_field]) ? $this->data[$table_id_field] : null;
	}

	/**
	 *
	 * @return string
	 */
	public function getTableName() {
		return $this->table_name;
	}

	/**
	 *
	 * @return string
	 */
	public function getTableIdField() {
		return $this->table_id_field;
	}

	public function mapDataFromObject(stdClass $data)
	{
		foreach($data as $key => $value)
		{
			$this->data[$key] = $value;
		}

		return $this;
	}

	/**
	 *
	 * @return string
	 */
	private function getDataForQuery()
	{
		end($this->data); // sed array pointer to the end of data array
		$last_key = key($this->data); // get last lement field name
		$response = '';

		foreach($this->data as $field => $value) {
			if($field == $this->getTableIdField()) continue;
			 
			$response .= '`' . $field . '`' . ' = :' . $field . ($last_key == $field ? '' : ', ');
		}

		return $response;
	}
}