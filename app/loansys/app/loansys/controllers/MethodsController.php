<?php

class MethodsController extends Controller
{

	public function emptyAction()
	{
		if(!APP_DEBUG)
			return;
		$class = null;
		switch($this->getActionName()){
			case 'di':
				global $di;
				$class = $di;
				break;
			case 'dispatcher':
				global $di;
				$class = $di->get('dispatcher');
				break;
			case 'controller':
				$class = '\Phf\Mvc\Controller';
				break;
			case 'view':
				$class = '\Phf\Mvc\View';
				break;
			case 'model':
				$class = '\Phf\Mvc\Model';
				break;
			case 'db':
				$class = '\Phf\Db\Adapter\Pdo\Mysql';
				break;
			case 'criteria':
				$class = 'Phf\Mvc\Model\Criteria';
				break;
			case 'url':
				$class = '\Phf\Mvc\Url';
				break;
			case 'router':
				$class = '\Phf\Mvc\Router';
				break;
			case 'metadata':
				$class = '\Phf\Mvc\Model\MetaData';
				break;
			case 'session':
				$class = '\Phf\Session\Adapter\Files';
				break;
			case 'volt':
				$class = '\Phf\Mvc\View\Engine\Volt';
				break;
			case 'response':
				$class = '\Phf\Http\Response';
				break;
			case 'gd':
				$class = '\Phf\Image\Adapter\GD';
				break;
			case 'image':
				$class = '\Phf\Image';
				break;
			case 'imagick':
				$class = '\Phf\Image\Adapter\Imagick';
				break;
			case 'security':
				$class = '\Phf\Security';
				break;
			case 'memory':
				$class = '\Phf\Cache\Backend\Memory';
				break;
			default:
				$class = ucwords($this->getActionName()) . 'Controller';
				if(!class_exists($class))
					$class = __CLASS__;
				break;
		}
		$reflectionClass = new ReflectionClass($class);
		$methods = $reflectionClass->getMethods();

		$str = '';
		foreach($methods as $method){
			$docComment = $method->getDocComment();
			if($docComment)
				$str .= $docComment . "<br/>";
			if($method->isAbstract())
				$str .= '#abstract#';
			if($method->isFinal())
				$str .= '#final#';
			if($method->isPublic())
				$str .= '#public#';
			if($method->isPrivate())
				$str .= '#private#'; 
			if($method->isProtected())
				$str .= '#protected#';
			if($method->isStatic())
				$str .= '#static#';
			$str .= "#function#|{$method->name}| (";
			$paramStr = '';
			foreach($method->getParameters() as $param){
				$showOptional = false;
				if($param->isOptional())
					$showOptional = true;

				if($showOptional)
					$paramStr .= empty($paramStr) ? '[ ' : '&nbsp;[, ';
				if($param->isArray())
					$paramStr .= '(array) ';
				$paramStr .= "{$param->name}";
				if($param->isDefaultValueAvailable())
					$paramStr .= "{$param->getDefaultValue()}";
				//else if($param->isDefaultValueConstant())
				//	$str .= "{$param->getDefaultValueConstantName()}";
				if($showOptional)
					$paramStr .= ' ]';
			}
			$str .= trim($paramStr, ', ');
			$str .= ") <br/><br/>";
		}
		echo static::highlight($str);
	}

	private static function highlight($str)
	{
		$docCommentPattern = '/\/(\*+([^\*\/])\*+)\//';
		$callback = function($matches){
			if(in_array($matches[2], array('final', 'static')))
				return "<font color='green'>{$matches[2]} </font>";
			if(in_array($matches[2], array('public', 'protected', 'private')))
				return "<font color='green'>{$matches[2]} </font>";
			if(in_array($matches[2], array('function')))
				return "<font color=''>{$matches[2]} </font>";
			if(preg_match('/|[\w]|/', $matches[1]))
				return "<font color='blue'><b>{$matches[2]}<b> </font>";
		};
		$str = preg_replace_callback(array('/(\/\/[^\r\n])/', $docCommentPattern, '/([#|]{1}(([\_]{1,2})?[\w]+)[#|]{1})/'), $callback, $str);
		return $str;
	}

}
