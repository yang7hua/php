<?php

class DepartmentController extends Controller
{
	public function listAction()
	{
		$departments = Department::find();
		$this->view->setVar('departments', $departments);
	}

	public function addAction()
	{
	}
}
