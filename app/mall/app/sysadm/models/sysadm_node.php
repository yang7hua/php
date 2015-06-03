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
		$result = $this->ok_select();

		$nodes = [];
		foreach ($result as $node) 
		{
			if ($node->pid == 0)
			{
				$nodes[$node->id] = [
					'name'	=>	$node->name,
					'nodes'	=>	[]
				];
			}
			else if (array_key_exists($node->pid, $nodes))
			{
				$nodes[$node->pid]['nodes'][$node->id] = (array) $node;
			} 
			else 
			{
				foreach ($nodes as &$row)		
				{
					foreach ($row['nodes'] as $pid=>$r)
					{
						if ($pid == $node->pid)
						{
							$row['nodes'][$pid]['nodes'][$node->id] = (array) $node;	
							break;
						}	
					}
				}
			}
		}
		return $nodes;
	}

	function total($status = null)
	{
		return $this->db->select('id')->from('sysadm_node')->count_all_results();
	}

	function all()
	{
		return $this->db->from('sysadm_node')->get()->result();
	}

	function select($offset = 0, $size = 10)
	{
		return $this->db->from('sysadm_node')->limit($size, $offset)
			->order_by('id', 'desc')->get()->result();
	}

	function ok_select($offset = 0, $size = 10)
	{
		$map['status'] = self::STATUS_OK;
		return $this->db->from('sysadm_node')->where($map)->limit($size, $offset)
			->order_by('pid asc, sortno asc')->get()->result();
	}

	function create($data)
	{
		return $this->db->insert('sysadm_node', $data);
	}

}
