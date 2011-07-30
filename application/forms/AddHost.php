<?php
class Form_AddHost extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('addHost');

        $name = $this->_getNameElement();
        $hostName = $this->_getHostNameElement();

        $this->addElements(array($name, $hostName));
    }

    protected function _getNameElement() {
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('name')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to enter a name'));
		
        return $element;
    }

    protected function _getHostNameElement() {
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('name')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to enter a hostname'));
		
        return $element;
    }	
}