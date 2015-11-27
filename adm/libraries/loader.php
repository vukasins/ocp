<?php

/**
 *
 * @author Lajavi Krelac
 *
 */
class Libraries_Loader
{
	private static $instance = null;

	private $name_separator = '_';
	private $file_extension = '.php';

	private function __clone()
	{
	}

	private function __construct()
	{
	}

	/**
	 * Register autoloader.
	 *
	 * @return bool
	 */
	public function register()
	{
		return spl_autoload_register(array($this, 'autoload'), true);
	}

	/**
	 * Unregister autoload.
	 *
	 * @return bool
	 */
	public function unregister()
	{
		return spl_autoload_unregister(array($this, 'autoload'));
	}

	/**
	 * @param string $class_name
	 * @return bool
	 */
	public function autoload($class_name)
	{
		$file_name = $this->convertToFileName($class_name);
		
		if(file_exists(APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name))
		{
			return require APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name;
		}
		elseif(file_exists(ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name))
		{
			return require ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name;
		}
		elseif(file_exists(PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name))
		{
			return require PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . $file_name;
		}

		return false;
	}

	public function getNameSeparator()
	{
		return $this->name_separator;
	}

	public function getFileExtension()
	{
		return $this->file_extension;
	}

	/**
	 * Convert string to valid file name
	 * @param string $string
	 * @return string
	 */
	public function convertToFileName($string)
	{
		return strtolower(str_replace($this->name_separator, DIRECTORY_SEPARATOR, $string)) . $this->file_extension;
	}

	/**
	 * Convert string to class name
	 * @param string $string
	 * @return string
	 */
	public function convertToClassName($string)
	{
		$class_name_chunks = explode($this->name_separator, $string);
		$class_name = '';

		foreach($class_name_chunks as $i => $class_name_chunk)
		{
			$class_name .= ucfirst($class_name_chunk) . $this->name_separator;
		}

		$class_name = trim($class_name, $this->name_separator);

		return $class_name;
	}

	/**
	 * @return Libraries_Loader
	 */
	public static function getInstance()
	{
		if(empty(self::$instance) || !(self::$instance instanceof Libraries_Loader))
		{
			self::$instance = new Libraries_Loader();
		}

		return self::$instance;
	}
}