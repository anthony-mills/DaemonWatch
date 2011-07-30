<?php
class Form_AddService extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setName('addHost');

        $name = $this->_getNameElement();
        $port = $this->_getPortElement();
        $frequency = $this->_getFrequencyElement();		

        $this->addElements(array($name, $port, $frequency));
    }

    protected function _getNameElement() {
        $element = new Zend_Form_Element_Text('name');
        $element->setLabel('name')
				->addValidator('StringLength', false, array(1, 200))
				->setRequired(true)
				->setErrorMessages(array('You need to enter a name'));
		
        return $element;
    }

    protected function _getPortElement() {
        $element = new Zend_Form_Element_Text('port');
        $element->setLabel('servicePort')
				->addValidator('StringLength', false, array(1, 5))
				->setRequired(true)
				->setErrorMessages(array('You need to enter the port of the service'));
		
        return $element;
    }	
		
	
    protected function _getFrequencyElement() {
        $element = new Zend_Form_Element_Select('serviceFrequency');
		$frequency = array('60' => '1 min', '120' => '2 min', '180' => '3 min', '240' => '4 min',
						   '300' => '5 min', '600' => '10 min', '900' => '15 min', '1200' => '20 min',
						   '1500' => '25 min', '1800' => '30 min', '3600' => '60 min', '7200' => '120 min');
        $element->setLabel('frequency')
				->setMultiOptions($frequency);
		
        return $element;
    }		
}