<?php

class Crud_Models_Field extends Libraries_Db_Mysql_Model
{
	/**
	 *
	 * @var 
	 */
	public $control = null;
	
	public $list_control = null;
	
	public $search_control = null;

	public $validators = array();

	public function __construct(array $data = array())
	{
		parent::__construct('sys_field', $data);
	}

	public function loadControl()
	{
		$this->control = new Controls_Models_Control();
		$this->control->load($this->id_sys_control);

		return $this;
	}

	public function loadListControl()
	{
		$this->list_control = new Controls_Models_Control();
		$this->list_control->load($this->id_sys_list_control);

		return $this;
	}
	
	public function loadSearchControl()
	{
		$this->search_control = new Controls_Models_Control();
		$this->search_control->load($this->id_sys_search_control);

		return $this;
	}

	public function loadValidators()
	{
		if($this->ids_sys_validator == '')
		{
			return $this;
		}
		 
		$ids_validator = explode(',', trim($this->ids_sys_validator));
		 
		foreach($ids_validator as $id_validator)
		{
			$validator = new Validators_Models_Validator();
			$validator->load($id_validator);

			$this->validators[] = $validator;
		}
		 
		return $this;
	}
}