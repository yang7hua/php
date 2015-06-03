<?php

class Node extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('\Models\Sysadm_node', 'node');
	}

	function create()
	{
		$data = $this->input->request();
		//$this->node->create($data);
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

}
