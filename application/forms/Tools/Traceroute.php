<?php
class Form_Tools_Traceroute extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('addHost');

        $hostName = $this->_getHostNameElement();

        $this->addElements(array($hostName));
    }

    protected function _getHostNameElement() {
        $element = new Zend_Form_Element_Text('hostname');
        $element->setLabel('hostname')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to enter a hostname'));
		
        return $element;
    }	
}