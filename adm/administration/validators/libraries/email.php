<?php

class Validators_Libraries_Email
{
	public static function validate($value)
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL);
	}
	
	public static function getFalseMessage()
	{
		return 'Required valid email';
	}
}