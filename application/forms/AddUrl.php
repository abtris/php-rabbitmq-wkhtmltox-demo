<?php

class Application_Form_AddUrl extends Zend_Form
{
    public function init()
    {
        $this->addElement('textarea','url', array(
            'label'=>'URLs',
            'required' => true,
            'description' => "Add one url into one row"
        ));

        $this->addElement('submit', 'process', array(
            'label' => "Procced"
        ));
    }
}