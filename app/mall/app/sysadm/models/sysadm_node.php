<?php

namespace Models;

class Sysadm_node extends Model
{
	const STATUS_OK = 1;
	/**
	 * 将所有的node以树的形式返回
	 */
	function tree()
	{
		$map['status'] = self::STATUS_OK;
		$result = $this->db->from('sysadm_node')->where($map)->get()->result();

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
			else
			{
				$nodes[$node->pid]['nodes'][] = (array) $node;
			}
		}
		return $nodes;
	}

	function create($data)
	{
		return $this->db->insert('sysadm_node', $data);
	}

}
