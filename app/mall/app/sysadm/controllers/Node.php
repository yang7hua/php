<?php

class Node extends Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('model_sysadm_node', 'node');
	}

	function create()
	{
		$data = $this->input->request();
		$this->node->create($data);
	}
}
