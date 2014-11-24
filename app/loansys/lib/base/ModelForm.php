<?php

namespace Base;

class ModelForm
{
	protected $data = null;
	private $ruleType = null;
	
	public function __construct($ruleType = 'add', $data = [])
	{
		$this->ruleType = $ruleType;
		$this->data = $data;
	}

	/**
	 * 验证数据
	 */
	public function validate($data)
	{
		$fields = self::getFields();

		$this->data = (new Validator($fields, $data))->validate();
		if (!$this->data)
			return false;
		return true;
	}

	private static $inputTemplate = <<<EOT
		<div class='form-group'>
			<label class='{labelClass} control-label'>{label}</label>
			<div class='{inputClass}'>{input}<div class='help-block'></div></div>
			<div class='{remarkClass} remark'>{remark}</div>
		</div>
EOT;

	private static $buttonTemplate = <<<EOT
		<div class='form-group'>
			<label class='col-lg-2 control-label'></label>
			<div class='col-lg-6'>
				<button type='{type}' {attrs} class='{class}'>{name}</button>
			</div>
		</div>
EOT;

	public static function fields()
	{
		return [];
	}

	private function getFields()
	{
		return $this->fields()[$this->ruleType];
	}

	public function beginForm(array $attrs = [])
	{
		$html = '<form class="form-horizontal"';
		isset($attrs['method']) or $attrs['method'] = 'post';
		if (!empty($attrs)) {
			foreach ($attrs as $attr=>$value)
				$html .=	"$attr='$value'";
		}
		$html .= '>';
		return $html;
	}

	public function endForm()
	{
		return '</form>';
	}

	public function renderFields(array $fields = [])
	{
		empty($fields)	and $fields = $this->getFields();
		$html = null;
		foreach ($fields as $field=>$options) {
			if (!$options)
				continue;
			switch ($options['type']) {
				case 'select':
					$html .= self::selectInput($field, $options); 
					break;
				case 'plain':
					$html .= self::plain($field, $options); 
					break;
				case 'hidden':
					$html .= self::hiddenInput($field, $options);
					break;
				default:
					$html .= self::input($field, $options, $options['type']); 
					break;
			}
		}
		return $html;
	}

	public function renderField($label, $input, $type = 'input', $options = [])
	{
		switch ($type) {
			default:
				$template = self::$inputTemplate;
				break;
		}
		$labelClass = isset($options['labelOptions']['class']) ? $options['labelOptions']['class'] : 'col-lg-2';
		$inputClass = isset($options['inputOptions']['class']) ? $options['inputOptions']['class'] : 'col-lg-3';
		$remarkClass = isset($options['remarkOptions']['class']) ? $options['remarkOptions']['class'] : 'col-lg-2';
		$pattern = ['{input}', '{label}', '{labelClass}', '{inputClass}', '{remark}', '{remarkClass}'];
		$replace = [$input, $label, $labelClass, $inputClass, $options['remark'], $remarkClass];
		return str_replace($pattern, $replace, $template);
	}

	public function input($field, array $options = [], $type = 'text')
	{
		$attrs['type'] = $type;
		$attrs['name'] = $field;
		if (isset($options['validator']))
			$attrs['class'] = self::getClass($options['validator']);
		if (isset($this->data[$field]) and in_array($type, ['text']))
			$attrs['value'] = $this->data[$field];

		$input = '<input ';
		$input .= self::getAttrs($attrs);
		$input .= '/>';

		return self::renderField($options['label'], $input, 'text', $options);
	}

	public function plain($field, $options = [])
	{
		$input = $options['default'];
		if (isset($this->data[$field]))
			$input = $this->data[$field];
		$input = '<label class="control-label plain">' . $input . '</label>';
		return self::renderField($options['label'], $input, 'plain');
	}

	public function hiddenInput($field, $options = [])
	{
		$str = '<input type="hidden" name="'.$field.'"';
		if (isset($this->data[$field]))
			$str .= " value={$this->data[$field]} ";
		$str .= '/>';
		return $str;
	}

	public function selectInput($field, array $options = [])
	{
		$attrs['name'] = $field;
		$attrs['class'] = self::getClass($options['validator']);

		$input = '<select';
		$input .= self::getAttrs($attrs);
		$input .= '/>';

		$input .= self::getSelectOptions($options['options'], $field);

		$input .= '<select>';

		return self::renderField($options['label'], $input, 'select', $options);
	}

	private function getSelectOptions($options, $field)
	{
		$str = null;
		
		$selected = $options['default'];
		if (isset($this->data[$field]))
			$selected = $this->data[$field];
		foreach ($options as $option) {
			$str .= '<option value="'.$option['value'].'"';
			if ($option['value'] == $selected)
				$str .= ' selected ';
			$str .= '>' . $option['name'] . '</option>';
		}
		return $str;
	}

	public function button($name, array $options = [], $type = 'submit')
	{
		$template = isset($options['template']) ? $options['template'] : self::$buttonTemplate;
		$class = isset($options['class']) ? $options['class'] : 'btn btn-primary';
		$attrs = empty($options) ? '' : self::getAttrs($options);

		$pattern = ['{type}', '{name}', '{class}', '{attrs}'];
		$replace = [$type, $name, $class, $attrs];
		return str_replace($pattern, $replace, $template);
	}

	private function getAttrs(array $options = [])
	{
		$html = null;
		foreach ($options as $key=>$attr) {
			$html .= " $key=\"$attr\"";
		}
		return $html;
	}

	private function getClass(array $options = [])
	{
		$class = 'form-control ';
		if (!empty($options)) {
			$class .= '{';
			foreach ($options as $k=>$v) {
				$class .= "$k:";
				$class .= (is_string($v) ? "'$v'" : $v);
				$class .= ',';
			}
			$class = substr($class, 0, -1);
			$class .= '}';
		}
		return $class;
	}

	public function registerValidateJs()
	{
		$code = null;
		\Func\registerJs($code);
	}
}

class Validator
{

	private $rules = null;

	private $data = null;

	//验证错误信息
	private $errors = [];

	//验证后的数据
	private $validated = [];

	public function __construct($rules, $data = [])
	{
		$this->rules = $rules;
		$this->data = $data;
	}

	public function validate()
	{
		$validated = [];
		foreach ($this->rules as $key=>$row) {
			switch ($key) {
				case 'password':
					self::password($key);
					break;
				case 'repassword':
					self::confirm($key, 'password');
					break;	
				default:
					self::vali($key);
					break;
			}	
		}
		if ($this->hasError())
			return false;
		return $this->validated;
	}

	private function is_required($field)
	{
		$validator = $this->getValidator($field);
		return isset($validator['required']) and $validator['required'];
	}

	private function is_empty($field)
	{
		$value = $this->getData($field);
		return empty($value);
	}

	private function required($field)
	{
		if (self::is_required($field) and $this->is_empty($field))
			$this->logError($field, 'required');
	}

	public function vali($field)
	{
		$rule = $this->getRule($field);
		if (in_array($rule['type'], ['plain']))
			return;
		$this->setValidated($field, $this->getData($field));
	}

	public function password($field)
	{
		$this->required($field);
		if (!$this->is_empty($field))
			$this->setValidated($field, \Func\password($this->getData($field)));
	}

	public function confirm($field, $equalTo = 'password')
	{
		if ($this->getData($field) != $this->getData($equalTo))
			$this->logError($field, 'confirm');
	}

	public function getData($field)
	{
		return isset($this->data[$field]) ? $this->data[$field] : $this->getRule($field)['default'];
	}

	public function getRule($field)
	{
		return isset($this->rules[$field]) ? $this->rules[$field] : [];
	}

	public function getValidator($field)
	{
		$rule = $this->getRule($field);
		return isset($rule['validator']) ? $rule['validator'] : null;
	}

	public function setValidated($field, $value)
	{
		$this->validated[$field] = $value;
	}

	private function logError($field, $type)
	{
		switch ($type) {
			case 'required':
				$msg = '不能为空';
				break;
			case 'confirm':
				$msg = '不一致';
				break;
		}
		array_push($this->errors, "{$this->data[$field]['label']}$msg");
	}

	private function hasError()
	{
		return !empty($this->errors);
	}
}
