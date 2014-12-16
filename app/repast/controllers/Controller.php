<?php
/**
 * 基类
 */
namespace app\controllers;

abstract class Controller extends \yii\web\Controller
{

	protected $view = null;

	protected $params = null;

	public function init()
	{
		!$this->view and $this->view = $this->getView();

		!empty($this->params) and $this->view->params = $this->params;
	}

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
			//验证码
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
				'width'	=>	100,
				'minLength'	=>	4,
				'maxLength'	=>	5,
				'transparent'	=>	true
            ],
        ];
    }

	public function noLayout()
	{
		$this->layout = false;
	}

}
