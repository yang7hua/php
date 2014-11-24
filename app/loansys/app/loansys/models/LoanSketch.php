<?php

class LoanSketch extends Model
{
	public function getSource()
	{
		global $config;
		return $config->database->prefix . 'loan_sketch';
	}

}
