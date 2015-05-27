<?php

class Model_admini extends CI_Model
{
	const STATUS_OK = 1;

	function find_by_aname($aname)
	{
		$row = $this->db 
			->from('admini')
			->where('aname', $aname)
			->limit(1)
			->get();
		return $row->row();
	}

	function create($username, $password, $role_id, $status = null)
	{
		is_null($status) and $status = self::STATUS_OK;
		$data = [
			'aname'	=>	$username,
			'password'	=>	password($password),
			'role_id'	=>	$role_id,
			'addip'	=>	$this->input->ip_address(),
			'addtime'	=>	time(),
			'status'	=>	$status
		];
		return $this->db->insert('admini', $data);
	}

	function is_ok($status)
	{
		return $status == self::STATUS_OK;
	}
}
