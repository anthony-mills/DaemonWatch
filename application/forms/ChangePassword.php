<?php
class Form_ChangePassword extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('changePassword');

        $newPassword = $this->_getNewPasswordElement();
        $repeatPassword = $this->_getRepeatPasswordElement();

        $this->addElements(array($newPassword, $repeatPassword));
    }

    protected function _getNewPasswordElement() {
        $element = new Zend_Form_Element_Password('newPassword');
        $element->setLabel('newPassword')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('StringLength', false, array(1, 200));
		$element->setRequired(true)->setErrorMessages(array('You need to enter your new password'));
						  

        return $element;
    }

    protected function _getRepeatPasswordElement() {
        $element = new Zend_Form_Element_Password('repeatPassword');
        $element->setLabel('repeatPassword')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to repeat your new password'));
		
        return $element;
    }
	
}