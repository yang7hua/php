<?php

class Product_attr extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('\Models\Product_attr', 'product_attr');
	}

	function _list()
	{
		if (is_ajax())
		{
			list($offset, $size, $p) = $this->limit();

			$total = $this->product_attr->total();
			$this->load->library('page', [$total, $size, $p], 'page');

			$list = $this->product_attr->ok_select($size, $offset);

			$this->success([
				'list'	=>	$list,
				'page'	=>	$this->page->getPage(),
			]);
		}
		$attrs = $this->product_attr->attrs();
		return $this->load->view('product/attr_list', [
			'attrs'	=>	$attrs
		]);
	}

	function create()
	{
		$data = $this->input->request();
		empty($data['pa_name']) and $this->error('属性值不能为空');

		if (isset($data['pa_id']) and $data['pa_id'])
		{
			$id = $data['pa_id'];
			$res = $this->product_attr->update($id, $data);
		}
		else
		{
			$res = $this->product_attr->create($data);
		}

		if ($res)
		{
			$this->success('添加成功');
		}
		else
		{
			$this->error('操作失败');
		}
	}

}
