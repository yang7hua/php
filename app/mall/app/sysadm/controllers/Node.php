<?php

class Node extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('\Models\Sysadm_node', 'node');
	}

	function _list()
	{
		if (is_ajax())
		{
			list($offset, $size, $p) = $this->limit();

			$total = $this->node->total();
			$this->load->library('page', [$total, $size, $p], 'page');

			$nodes = $this->node->select($offset, $size);
			$this->success([
				'list'	=>	$nodes,
				'page'	=>	$this->page->getPage(),
			]);
		}
		return $this->load->view('node/list');
	}

	function create()
	{
		$data = $this->input->request();
		if (isset($data['id']) and $data['id'])
		{
			$id = intval($data['id']);
			$res = $this->node->update($id, $data);
		}
		else 
		{
			$res = $this->node->create($data);
		}
		if ($res === false)
			$this->error('操作失败');
		$this->success('操作成功');
	}

}
