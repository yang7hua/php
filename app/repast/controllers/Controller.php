<?php

namespace app\controllers;

abstract class Controller extends \yii\web\Controller
{

	protected $view = null;

	protected $params = [
		'title' => '',
		'keywords'	=>	['订餐系统'],
		'description'	=>	'订餐系统'
	];

	public function init()
	{
		!$this->view and $this->view = $this->getView();

		$this->view->params = $this->params;
		$this->view->title = 'abc';
	}

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

}
