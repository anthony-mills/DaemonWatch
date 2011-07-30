<?php
class Form_ResetPassword extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('userLogin');

        $email = $this->_getEmailElement();
		
        $this->addElements(array($email));
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
	
}