<?php

class ModelForm
{
	private static $inputTemplate = <<<EOT
		<div class='form-group'>
			<label class='{labelClass} control-label'>{label}</label>
			<div class='{inputClass}'>{input}<div class='help-block'></div></div>
			<div class='col-lg-2 remark'>{remark}</div>
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

	public function fields()
	{
		return [];
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

	public static function endForm()
	{
		return '</form>';
	}

	public function renderFields(array $fields = [])
	{
		empty($fields)	and $fields = $this->fields();
		$html = null;
		foreach ($fields as $field=>$options) {
			if (!$options)
				continue;
			switch ($options['type']) {
				case 'select':
					$html .= self::selectInput($field, $options); 
					break;
				default:
					$html .= self::textInput($field, $options); 
					break;
			}
		}
		return $html;
	}

	public static function renderField($label, $input, $type = 'input', $options = [])
	{
		switch ($type) {
			default:
				$template = self::$inputTemplate;
				break;
		}
		$labelClass = isset($options['labelOptions']['class']) ? $options['labelOptions']['class'] : 'col-lg-2';
		$inputClass = isset($options['inputOptions']['class']) ? $options['inputOptions']['class'] : 'col-lg-8';
		$pattern = ['{input}', '{label}', '{labelClass}', '{inputClass}', '{remark}'];
		$replace = [$input, $label, $labelClass, $inputClass, $options['remark']];
		return str_replace($pattern, $replace, $template);
	}

	public static function textInput($field, array $options = [])
	{
		$attrs['type'] = 'text';
		$attrs['name'] = $field;
		$attrs['class'] = self::getClass($options['validator']);

		$input = '<input ';
		$input .= self::getAttrs($attrs);
		$input .= '/>';

		return self::renderField($options['label'], $input, 'text', $options);
	}

	public static function selectInput($field, array $options = [])
	{
		$attrs['name'] = $field;
		$attrs['class'] = self::getClass($options['validator']);

		$input = '<select';
		$input .= self::getAttrs($attrs);
		$input .= '/>';

		$input .= self::getSelectOptions($options['options']);

		$input .= '<select>';

		return self::renderField($options['label'], $input, 'select', $options);
	}

	private static function getSelectOptions($options)
	{
		$str = null;
		foreach ($options as $option) {
			$str .= '<option value="'.$option['value'].'">' . $option['name'] . '</option>';
		}
		return $str;
	}

	public static function button($name, array $options = [], $type = 'submit')
	{
		$template = isset($options['template']) ? $options['template'] : self::$buttonTemplate;
		$class = isset($options['class']) ? $options['class'] : 'btn btn-primary';
		$attrs = empty($options) ? '' : self::getAttrs($options);

		$pattern = ['{type}', '{name}', '{class}', '{attrs}'];
		$replace = [$type, $name, $class, $attrs];
		return str_replace($pattern, $replace, $template);
	}

	private static function getAttrs(array $options = [])
	{
		$html = null;
		foreach ($options as $key=>$attr)
			$html .= " $key='$attr'";
		return $html;
	}

	private static function getClass(array $options = [])
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

	public static function registerValidateJs()
	{
		$code = null;
		\Func\registerJs($code);
	}
}
