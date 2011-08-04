<?php
class Form_Admin_AddUSer extends Zend_Form {
	public function __construct($options = null) {
		parent::__construct($options);
		$this -> setName('addUser');

		$this -> addElements(array($this -> _getFirstNameElement(), $this -> _getLastNameElement(), $this -> _getUserEmailElement(), 					
		                           $this -> _getHostLimitElement(), $this -> _getServiceLimitElement(), $this -> _getSMSCreditsElement()));
	}

	protected function _getFirstNameElement() {
		$element = new Zend_Form_Element_Text('first_name');
		$element -> setLabel('First Name') -> addValidator('StringLength', false, array(1, 200)) -> setRequired(true) -> setErrorMessages(array('You need to enter a first name'));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _getLastNameElement() {
		$element = new Zend_Form_Element_Text('last_name');
		$element -> setLabel('Last Name') -> addValidator('StringLength', false, array(1, 200)) -> setRequired(true) -> setErrorMessages(array('You need to enter a last name'));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _getUserEmailElement() {
		$element = new Zend_Form_Element_Text('email');
		$element -> setLabel('Email') -> addValidator('EmailAddress') -> setErrorMessages(array('You need to enter a last name'));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _getHostLimitElement() {
		$element = new Zend_Form_Element_Text('host_limit');
		$element -> setLabel('Host Limit') -> addValidator('StringLength', false, array(1, 10));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _getServiceLimitElement() {
		$element = new Zend_Form_Element_Text('service_limit');
		$element -> setLabel('Service Limit') -> addValidator('StringLength', false, array(1, 10));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _getSMSCreditsElement() {
		$element = new Zend_Form_Element_Text('sms_credits');
		$element -> setLabel('SMS credits') -> addValidator('StringLength', false, array(1, 10));
		$element = $this -> _addGenericFilter($element);

		return $element;
	}

	protected function _addGenericFilter($element) {
		$element -> addFilter('StripTags') -> addFilter('StringTrim') -> addValidator('StringLength', false, array(1, 200)) -> setRequired(true);
		return $element;
	}

}
