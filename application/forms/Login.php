<?php
class Form_Login extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('userLogin');

        $email = $this->_getEmailElement();
        $password = $this->_getPasswordElement();

        $this->addElements(array($email, $password));
    }

    protected function _getEmailElement() {
        $element = new Zend_Form_Element_Text('email');
        $element->setLabel('Email')
                ->addValidator('EmailAddress')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('StringLength', false, array(1, 200));
		$element->setRequired(true)->setErrorMessages(array('You need to enter a valid email address'));
						  

        return $element;
    }

    protected function _getPasswordElement() {
        $element = new Zend_Form_Element_Password('password');
        $element->setLabel('Password')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to enter your password'));
		
        return $element;
    }
	
}