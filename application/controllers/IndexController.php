<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $r = new Application_Model_Rabbit();
        $this->view->form = $form = new Application_Form_AddUrl();
        // process form
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getParams();
            if ($form->isValid($formData)) {
                $r->setUrl($form->url->getValue());
            } else {
                $form->populate($formData);
            }
        }

        $this->view->url = $r->getUrl();
    }


}

