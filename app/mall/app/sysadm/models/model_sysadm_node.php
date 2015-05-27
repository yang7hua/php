<?php

class Model_sysadm_node extends CI_Model
{
	/**
	 * 将所有的node以树的形式返回
	 */
	function tree()
	{
		$result = $this->db->from('sysadm_node')->get()->result();

		$nodes = [];
		foreach ($result as $node) 
		{
			if ($node->pid == 0)
			{
				$nodes[$node->id] = [
					'name'	=>	$node->name,
					'nodes'	=>	[]
				];
				continue;
			}
		}
		return $nodes;
	}

	function create($data)
	{
		return $this->db->insert('sysadm_node', $data);
	}

}
