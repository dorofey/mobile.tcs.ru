<?php

class ProductsController extends Zend_Controller_Action
{
    /**
     * @var Application_Model_DbTable_Products
     */
    protected $_products;

    public function init()
    {
        $this->_products = new Application_Model_DbTable_Products();
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

        $parent = Zend_Db_Table::getDefaultAdapter()->query($sql);
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
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_Db::FETCH_OBJ);
        $select = $db->select()
                ->from('prod_temp')
                ->where('prod_temp.prod_uniq = ?', $id)
                ->joinLeft('new_products_2', 'prod_temp.prod_uniq = new_products_2.`1c_id`');
        $res = $db->fetchRow($select);
        $this->_helper->layout()->home = '/products/' . $res->prod_cat . '/';
        $this->view->product = $res;
    }


}





