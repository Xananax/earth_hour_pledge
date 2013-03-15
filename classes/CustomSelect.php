<?php

namespace PFBC\Element;

class CustomSelect extends \PFBC\OptionElement {

	protected $_optGroup = '';

	public function __construct($label, $name, array $options, array $properties = null) {
		if($properties && isset($properties['optGroup'])){
			$this->_optGroup = $properties['optGroup'];
			unset($properties['optGroup']);
		}
		parent::__construct($label, $name, $options,$properties);
	}

	public function render() { 
		if(isset($this->_attributes["value"])) {
			if(!is_array($this->_attributes["value"]))
				$this->_attributes["value"] = array($this->_attributes["value"]);
		}
		else
			$this->_attributes["value"] = array();

		if(!empty($this->_attributes["multiple"]) && substr($this->_attributes["name"], -2) != "[]")
			$this->_attributes["name"] .= "[]";

		echo '<select', $this->getAttributes(array("value", "selected")), '>';
		if($this->_optGroup){
			//echo '<optgroup label="'.$this->_optGroup.'">';
			$optGroupSelected = !$this->_attributes["value"] ? ' selected="selected"' : '';
			echo '<option value="" disabled="disabled"'.$optGroupSelected.'>'
			.(is_array($this->_optGroup) ?  l($this->_optGroup[0],null,false,$this->_optGroup[1]) : $this->_optGroup)
			.'</option>';
		}
		$selected = false;
		foreach($this->options as $value => $text) {
			$value = $this->getOptionValue($value);
			echo '<option value="', $this->filter($value), '"';
			if(!$selected && in_array($value, $this->_attributes["value"])) {
				echo ' selected="selected"';
				$selected = true;
			}
			if(is_array($text)){
				echo '>', l($text[0],null,false,$text[1]), '</option>';
			}else{
				echo '>', $text, '</option>';
			}
		}
		if($this->_optGroup){
			//echo '</optgroup>';
		}
		echo '</select>';
	}
}