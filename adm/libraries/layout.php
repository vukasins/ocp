<?php

class Libraries_Layout
{
	private static $instance = null;

	protected $theme = '';

	/**
	 * Template name
	 * @var string
	 */
	protected $layout = '';
	
	/**
	 * 
	 * @var mixed
	 */
	protected $data = array();

	protected $region_content = array();

	protected function __construct()
	{
	}

	protected function __clone()
	{
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

	public function setTheme($theme)
	{
		$this->theme = $theme;
		return $this;
	}

	public function getTheme()
	{
		return $this->theme;
	}

	public function setLayout($layout)
	{
		$this->layout = $layout;
		return $this;
	}

	public function getLayout()
	{
		return $this->layout;
	}

	public function render()
	{
		ob_start();

		$file_path = PROJECT_ROOT_DIR . '/layout/' . $this->theme . '/' . $this->layout . '.php';
		
		extract($this->data);

		if ((bool) @ini_get('short_open_tag') === FALSE)
		{
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($file_path))));
		}
		else
		{
			include($file_path); // include() vs include_once() allows for multiple views with the same name
		}

		ob_end_flush();
	}

	public function setRegionContent($unique_region_name, $content)
	{
		$this->region_content[$unique_region_name] = $content;
		return $this;
	}

	public function renderRegion($unique_region_name)
	{
		return isset($this->region_content[$unique_region_name]) ? $this->region_content[$unique_region_name] : '';
	}

	/**
	 * @return Libraries_Layout
	 */
	public static function getInstance()
	{
		return empty(self::$instance) ? self::$instance = new self() : self::$instance;
	}
}