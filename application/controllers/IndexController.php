<?php

class IndexController extends Zend_Controller_Action
{

    protected $_config;

    public function preDispatch()
    {
            $this->_config = new Zend_Config_Ini('../application/configs/'.
                    'application.ini', APPLICATION_ENV);
    }

    public function indexAction()
    {
        $r = new Application_Model_Rabbit($this->_config->rabbitmq);

        $this->view->form = $form = new Application_Form_AddUrl();
        // process form
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getParams();
            if ($form->isValid($formData)) {
                $r->setUrl($form->url->getValue());
                $r->run();
            } else {
                $form->populate($formData);
            }
        }

        $this->view->url = $r->getUrl();
    }

    public function performAction()
    {
        $r = new Application_Model_Rabbit($this->_config->rabbitmq);
        $r->setUrl("http://www.seznam.cz");
        $r->run();
    }
}

