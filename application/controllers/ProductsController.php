<?php

class ProductsController extends Zend_Controller_Action
{
    /**
     * @var Application_Model_DbTable_Products
     */
    protected $_products;
    /**
     * @var Zend_Db_Adapter_Pdo_Mysql
     */
    protected $_db;
    protected $_dollar;

    public function init()
    {
        $this->_products = new Application_Model_DbTable_Products();
        $this->_db = Zend_Db_Table::getDefaultAdapter();
        $this->_dollar = $this->_db->query('SELECT * FROM `dollar` LIMIT 1')->fetchObject();
        $this->view->dollar = (float) $this->_dollar->dollar;
    }

    public function indexAction()
    {
        // action body
    }

    public function listAction()
    {
        $id = $this->_getParam('id');

        $sql = 'SELECT `rel_main` FROM `cat_rel`
                WHERE `rel_ones` = "' . $id . '"';

        $parent = $this->_db->query($sql);
        $parent->setFetchMode(Zend_Db::FETCH_OBJ);
        $parent = $parent->fetchObject();

        $this->_helper->layout()->home = '/catalog/' . $parent->rel_main . '/';

        $res = $this->_products->fetchAll(
            $this->_products->select()->where('prod_cat = ?', $id)->order('prod_name ASC')
        );
        $this->view->products = $res;

    }

    public function viewAction()
    {
        $id = $this->_getParam('id');

        $res = $this->_products->getFullProduct($id);
        $res->quantities = $this->_products->getProductQuantity($res->prod_id);

        $this->_helper->layout()->home = '/products/' . $res->prod_cat . '/';

        $this->view->product = $res;
        Zend_Debug::dump($res);
    }

}





