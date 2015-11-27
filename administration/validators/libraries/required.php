<?php

class Validators_Libraries_Required
{
	public static function validate($value)
	{
		return $value !== '';
	}
	
	public static function getFalseMessage()
	{
		return 'Required field';
	}
}