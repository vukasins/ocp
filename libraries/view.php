<?php

/**
 *
 * @author Lajavi Krelac
 *
 */
class Libraries_View
{
	private static $instance = null;

	/**
	 * Shared data. User in multiple views
	 * @var array
	 */
	protected static $shared_data = array();

	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 *
	 * @var string
	 */
	protected $module = '';

	/**
	 *
	 * @param string $module
	 */
	public function __construct($module = '')
	{
		if(!empty($module))
		{
			$this->module = $module;
		}
	}

	/**
	 * Magic setter method
	 * @param string $field
	 * @param string $value
	 */
	public function __set($field, $value)
	{
		$this->data[$field] = $value;
		return $this;
	}

	/**
	 * Magic getter method
	 * @param string $field
	 */
	public function __get($field)
	{
		return (isset($this->data[$field]) ? $this->data[$field] : null);
	}

	/**
	 *
	 * @param string $module
	 * @return Libraries_View
	 */
	public function setModule($module)
	{
		$this->module = $module;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getModule()
	{
		return $this->module;
	}

	/**
	 * Set shared data
	 * @param string $field
	 * @param string $value
	 * @return Libraries_View
	 */
	public function setSharedData($field, $value)
	{
		self::$shared_data[$field] = $value;
		return $this;
	}

	/**
	 * Get shared data
	 * @param string $field Data to get
	 */
	public function getSharedData($field)
	{
		return (isset(self::$shared_data[$field]) ? self::$shared_data[$field] : null);
	}

	/**
	 * Load selected view from module
	 * @param string $file File to load
	 * @param mixed $data Mixed array (key => value) of data for view
	 * @param bool $return Return view or echo
	 */
	public function load($file, $return = true)
	{
		ob_start();

		$file_path = $this->getFilePath($file);

		extract(self::$shared_data);
		extract($this->data);

		if ((bool) @ini_get('short_open_tag') === FALSE)
		{
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($file_path))));
		}
		else
		{
			include($file_path); // include() vs include_once() allows for multiple views with the same name
		}

		// Return the file data if requested
		if ($return === TRUE)
		{
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}

		ob_end_flush();
	}

	public function getFilePath($file)
	{
		if(file_exists(APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $file . '.php'))
		{
			return APPLICATION_ROOT_DIR . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $file . '.php';
		}
		elseif(file_exists(ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $file . '.php'))
		{
			return ADMIN_ROOT_DIR . DIRECTORY_SEPARATOR . $this->module . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $file . '.php';
		}
	}

	/**
	 * @return Libraries_View
	 */
	public static function getInstance($single_instance = false) {
		if($single_instance)
		{
			return new self();
		}
		 
		return empty(self::$instance) ? self::$instance = new self() : self::$instance;
	}
}
