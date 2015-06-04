<?php

namespace CI\Lib;

class Html
{
	public static function select($field, $options, $attrs=[], $selected=null, $keyval = true)
	{
		$attrs['class'] = self::analyseClass($attrs);
		$attrs_str = self::attrs($attrs);

		$html = '<select name="'.$field.'" '.$attrs_str.'>';
		//$html .= '<option>请选择</option>';
		foreach ($options as $val=>$text) {
			$val = $keyval ? $val : $text;
			$str_selected = (isset($selected) and $val == $selected) ? 'selected' : '';
			$html .= "<option value='{$val}' {$str_selected}>{$text}</option>";
		}
		$html .= '<select>';
		return $html;
	}

	public static function checkbox($field, $options, $checked=null, $keyval = true)
	{
		$html = null;
		foreach ($options as $val=>$text) {
			$val = $keyval ? $val : $text;
			$str_checked = (isset($checked) and $val == $checked) ? 'checked' : '';
			$html .= "<label><input type='checkbox' {$str_checked} name='{$field}' value='{$val}'>{$text}</label>";
		}
		return $html;
	}

	public static function radio($field, $options, $checked=null, $keyval = true)
	{
		$html = null;
		foreach ($options as $val=>$text) {
			$val = $keyval ? $val : $text;
			$str_checked = (isset($checked) and $val == $checked) ? 'checked' : '';
			$html .= "<label><input type='radio' name='{$field}' {$str_checked} value='{$val}'>{$text}</label>&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		return $html;
	}

	public static function textarea($field, $attrs=[], $value=null)
	{
		$attrs['class'] = self::analyseClass($attrs);
		$attrs_str = self::attrs($attrs);
		return '<textarea name="'.$field.'" '.$attrs_str.'>'.$value.'</textarea>';
	}

	public static function input($field, $attrs=[], $value=null)
	{
		$attrs['class'] = self::analyseClass($attrs);
		$attrs_str = self::attrs($attrs);
		$value = isset($value) ? 'value='.$value : '';
		return '<input name="'.$field.'" '.$attrs_str.' '.$value.'>';
	}

	public static function analyseClass($attrs=[], $formControl=true)
	{
		$class[] = $formControl ? 'form-control' : '';
		if (isset($attrs['class']))
			$class[] = $attrs['class'];
		return implode(' ', $class);
	}

	public static function attrs($attrs)
	{
		$attrs_str = null;
		foreach ($attrs as $attr=>$value)
		{
			$attrs_str .= " $attr=\"$value\" ";
		}
		return $attrs_str;
	}

	public static function tips($str, $type = 'success')
	{
		return '<p class="tips text-center bg-'.$type.'">'.$str.'</p>';
	}

	public static function to_options($array, $key, $value)
	{
		$options = [];
		foreach ($array as $row)
		{
			$row = (array) $row;
			$options[$row[$key]] = $row[$value];
		}
		return $options;
	}

}
