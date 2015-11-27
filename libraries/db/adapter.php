<?php

/**
 * Database interface. All drivers need have to implement this abstract class.
 * @author Lajavi Krelac
 *
 */
abstract class Libraries_Db_Adapter 
{
    const FETCH_TYPE_ASSOC = PDO::FETCH_ASSOC;
	const FETCH_TYPE_NUM = PDO::FETCH_NUM;
	const FETCH_TYPE_CLASS = PDO::FETCH_OBJ;

	public $pdo = null;

	protected function __construct() 
	{
	}
	
	protected function __clone() 
	{
	}

	/**
	 * @return Libraries_Db_Adapter
	 */
	public abstract function connect();

	/**
	 * @return null
	 */
	public abstract function disconnect();

	/**
	 * Execute custom string
	 *
	 * @param string $query
	 * @param array $data
	 * @return PDOStatement
	 */
	public abstract function execute($query, array $data = array());

	/**
	 * Fetch single row from query.
	 * 
	 * @param string $query
	 * @param array $data
	 * @param int $fetch_style
	 * @return mixed
	 */
	public abstract function fetchRow($query, array $data = array(), $fetch_style = self::FETCH_TYPE_ASSOC);
	
	/**
	 * @param string $query
	 * @param array $data
	 * @param int $fetch_style
	 * @return array
	 */
	public abstract function fetchAll($query, array $data = array(), $fetch_style = self::FETCH_TYPE_ASSOC);
	
	/**
	 * Fetch single column from query.
	 * 
	 * @param string $query
	 * @param array $data
	 * @param int $column_number
	 * @return string
	 */
	public abstract function fetchColumn($query, array $data = array(), $column_number = null);
	
	/**
	 * @param string $name
	 * @return string
	 */
	public abstract function lastInsertId($name = null); 
	
	/**
	 * @return string
	 */
	protected abstract function getConnectionString();

	/**
	 * @return Libraries_Db_Adapter
	 */
	public static function getInstance() 
	{
	}
    
}