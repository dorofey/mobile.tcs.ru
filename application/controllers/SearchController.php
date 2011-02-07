<?php

class SearchController extends Zend_Controller_Action
{
    private $_db;

    public function init()
    {
        $this->_helper->layout()->home = '/';

    }

    public function indexAction()
    {
    }

    public function postAction()
    {
        $this->_helper->layout()->home = '/search/';

        $this->_db = Zend_Db_Table::getDefaultAdapter();
        $this->_dollar = $this->_db->query('SELECT * FROM `dollar` LIMIT 1')->fetchObject();
        $this->view->dollar = (float) $this->_dollar->dollar;

        $q = $this->getRequest()->getParam('q', '');
        $products = new Application_Model_DbTable_Products();
        $res = $products->fetchAll(
            $products->select()->where('prod_name LIKE ?', '%' . $q . '%')->limit(25)
        );
        $this->view->products = $res;
    }
}

