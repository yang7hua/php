<?php
/**
 * 基类
 */
namespace app\controllers;

abstract class Controller extends \yii\web\Controller
{

	protected $view = null;

	protected $session = null;

	protected $publicActions = null;

	protected $homePage = '/';

	private $controllerName = null;

	private $actionName = null;

	/**
	 * 模板变量
	 */
	protected $params = null;

	public function init()
	{
		!$this->view and $this->view = $this->getView();
		!$this->session and $this->session = \Yii::$app->session;

		!empty($this->params) and $this->view->params = $this->params;

		$this->analyse();

		$this->checkAuth();
	}

	public function checkAuth()
	{
		
	}

	public function analyse()
	{
		$controller = $this->id;
		var_dump($this->module);
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
				'fixedVerifyCode'	=>	null,
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

	public function param($key)
	{
		return \Yii::$app->params[$key];
	}
}
