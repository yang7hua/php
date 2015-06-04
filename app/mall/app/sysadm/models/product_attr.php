<?php

namespace Models;

class Product_attr extends Model
{
	function total()
	{
		return $this->db->select('pa_id')->from('product_attr')->count_all_results();
	}

	function ok_select($size = null, $offset = 0, $type = null)
	{
		$query = $this->db->from('product_attr');
		if ($type !== null)
		{
			if ($type == 'attr')
				$map['pid'] = 0;
			else
				$map['pid !='] = 0;
		}
		if (isset($map))
		{
			$query = $query->where($map);
		}
		if ($size !== null and $offset !== null)
		{
			$query = $query->limit($size, $offset);
		}
		return $query->order_by('pa_id desc')->get()->result();
	}

	function attrs()
	{
		$list = $this->ok_select(null, null, 'attr');
		array_unshift($list, ['pa_id'=>0, 'pa_name'=>'--', 'pid'=>0]);

		return $list;
	}

	function create($data)
	{
		unset($data['pa_id']);
		return $this->db->insert('product_attr', $data);
	}

	function update($id, $data)
	{
		$id = intval($id);
		return $this->db->update('product_attr', $data, "pa_id=$id");
	}

}
