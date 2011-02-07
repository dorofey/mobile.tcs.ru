<?php

class IndexController extends Zend_Controller_Action
{
    protected $layout;

    public function init()
    {
        $this->_helper->layout()->home = '/';
    }

    public function indexAction()
    {
        // action body
    }


}

