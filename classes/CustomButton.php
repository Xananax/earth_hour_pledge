<?php

use PFBC\Element;

namespace PFBC\Element;

class CustomButton extends \PFBC\Element\Button{
	public function __construct($label = "Submit", $type = "", array $properties = null) {
		parent::__construct($label,$type,$properties);
	}
	public function render() {
		echo '<button', $this->getAttributes('value'), '>',$this->_attributes['value'],'</button>';
	}
}