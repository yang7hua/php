<?php

namespace Models;

class Product_type extends Model
{
	function total()
	{
		return $this->db->select('pt_id')->from('product_type')->count_all_results();
	}

	function ok_select($pid = null, $size = null, $offset = null)
	{
		$query = $this->db->select('pt.*, pta.pt_name pname')->from('product_type pt')
			->join('product_type pta', 'pt.pid=pta.pt_id', 'left');
		if ($pid !== null)
		{
			$map['pt.pid'] = intval($pid);
		}
		if (isset($map))
		{
			$query = $query->where($map);
		}
		if ($size !== null and $offset !== null)
		{
			$query = $query->limit($size, $offset);
		}
		return $query->order_by('pt.pt_id desc')->get()->result();
	}

	//一级目录
	function root_types()
	{
		$list = $this->ok_select(0, null);
		array_unshift($list, ['pt_id'=>0, 'pt_name'=>'--', 'pid'=>0]);

		return $list;
	}

	function create($data)
	{
		unset($data['pt_id']);
		return $this->db->insert('product_type', $data);
	}

	function update($id, $data)
	{
		$id = intval($id);
		return $this->db->update('product_type', $data, "pt_id=$id");
	}

}
