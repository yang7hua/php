<?php

class Product_type extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('\Models\Product_type', 'product_type');
	}

	function _list()
	{
		if (is_ajax())
		{
			list($offset, $size, $p) = $this->limit();

			$total = $this->product_type->total();
			$this->load->library('page', [$total, $size, $p], 'page');

			$list = $this->product_type->ok_select(null, $size, $offset);

			$this->success([
				'list'	=>	$list,
				'page'	=>	$this->page->getPage(),
			]);
		}
		//$this->load->model('\Models\Product_attr', 'product_attr');
		//一级目录
		$types = $this->product_type->root_types();
		return $this->load->view('product/type_list', [
			'types'	=>	$types
		]);
	}

	function create()
	{
		$data = $this->input->request();
		empty($data['pt_name']) and $this->error('分类名称不能为空');
		//empty($data['pta_id']) and $this->error('分类属性不能为空');

		if (isset($data['pt_id']) and $data['pt_id'])
		{
			$id = $data['pt_id'];
			$res = $this->product_type->update($id, $data);
		}
		else
		{
			$res = $this->product_type->create($data);
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
