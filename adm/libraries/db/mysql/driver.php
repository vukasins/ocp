<?php

/**
 * 
 * @author Lajavi Krelac
 *
 */
class Libraries_Db_Mysql_Driver extends Libraries_Db_Adapter 
{
    /**
     * 
     * @var Libraries_Db_Mysql_Driver
     */
	private static $instance = null;
	
	public function __construct() 
	{
	    $this->connect();
	}

	/**
	 * @see Libraries_Db_Mysql_Driver::connect()
	 */
	public function connect() 
	{
		$connection_string = $this->getConnectionString();
		$username = Config_Db_Mysql::USER;
		$password = Config_Db_Mysql::PASS;

		$options = array();

		if(Config_Db_Mysql::IS_PERSISTENT_CONNECTION === true) 
		{
			$options[PDO::ATTR_PERSISTENT] = true;
		}

		$options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';

		try 
		{
			$this->pdo = new PDO($connection_string, $username, $password, $options);
		}
		catch(PDOException $e) 
	    {
			throw $e;
		}

		return $this;
	}

	/**
	 * @see Libraries_Db_Mysql_Driver::disconnect()
	 */
	public function disconnect() 
	{
		$this->pdo = null;

		return null;
	}
	
	/**
	 * @see Libraries_Db_Mysql_Driver::execute()
	 */
	public function execute($query, array $data = array()) 
	{
		$statement = $this->pdo->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$statement->execute($data);
		
		return $statement;
	}
	
	/**
	 * @see Libraries_Db_Mysql_Driver::fetchRow()
	 */
	public function fetchRow($query, array $data = array(), $fetch_style = self::FETCH_TYPE_ASSOC) 
	{
		return $this->execute($query, $data)->fetch($fetch_style);
	}
	
	/**
	 * @see Libraries_Db_Mysql_Driver::fetchAll()
	 */
	public function fetchAll($query, array $data = array(), $fetch_style = self::FETCH_TYPE_ASSOC) 
	{
		return $this->execute($query, $data)->fetchAll($fetch_style);
	}
	
	/**
	 * @see Libraries_Db_Mysql_Driver::fetchColumn()
	 */
	public function fetchColumn($query, array $data = array(), $column_number = null) 
	{
		return $this->execute($query, $data)->fetchColumn($column_number);
	}
	
	/**
	 * @see Libraries_Db_Mysql_Driver::lastInsertId()
	 */
	public function lastInsertId($name = null) 
	{
		return $this->pdo->lastInsertId($name);
	} 
	
	/**
	 * @see Libraries_Db_Mysql_Driver::getConnectionString()
	 */
	protected function getConnectionString() 
	{
		return Config_Db_Mysql::DRIVER . ':host=' . Config_Db_Mysql::HOST . ';dbname=' . Config_Db_Mysql::BASE . ';port=' . Config_Db_Mysql::PORT;
	}

	public static function getInstance() {
		return empty(self::$instance) ? self::$instance = new self() : self::$instance;
	}
}