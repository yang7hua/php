<?php

class User extends Model
{


	protected function rawFields()
	{
		return ['contact_info', 'child_info', 'spouse_name', 'spouse_idcard', 'spouse_info', 'gender', 'birthdate'];
	}

	public static function add($data, $lastInsID = false)
	{
		$user = new User();
		$data['addtime'] = time();
		foreach ($data as $key=>$val) {
			$user->{$key}	=	$val;
		}
		if ($user->create()) {
			return $lastInsID ? $user->uid : true;
		}
			foreach ($user->getMessages() as $message) {
				echo $message, "\n";
			}
		return false;
	}
}
