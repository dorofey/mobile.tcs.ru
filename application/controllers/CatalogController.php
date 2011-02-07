<?php

class CatalogController extends Zend_Controller_Action {

    /**
     * @var Application_Model_DbTable_Catalog
     */
    protected $_cat;

    public function init() {
        $this->_cat = new Application_Model_DbTable_Catalog();
    }

    public function indexAction() {
        
        $this->_helper->layout()->home = '/';

        $res = $this->_cat->fetchAll(
            $this->_cat
                ->select()
                ->where('cat_parent = ?', 0)
                ->order('cat_name ASC')
        );
        $this->view->catalog = $res;
    }

    public function viewAction() {
        $this->_helper->layout()->home = '/catalog/';

        $id = $this->_getParam('id');
        $res = $this->_cat->fetchAll(
            $this->_cat
                ->select()
                ->where('cat_parent = ?', $id)
                ->order('cat_name ASC')
        );
        if($res->cat_parent[0] > 0) $this->_helper->layout()->home = '/catalog/' . $res->cat_parent[0] . '/';
        if(count($res) == 0) {

            $parent = $this->_cat->fetchRow(
                $this->_cat->select('cat_parent')->where('cat_id = ?', $id)->limit(1)
            );
            $this->_helper->layout()->home = '/catalog/' . $parent->cat_parent . '/';

            $db = Zend_Db_Table::getDefaultAdapter();
            $sql = 'SELECT *
                FROM `cat_rel` AS rel, `cat_temp` AS `cat`
                WHERE `rel`.`rel_ones` = `cat`.`cat_uniq` AND `rel`.`rel_main` = ' . $id;
            $res = $db->query($sql);
            $res->setFetchMode(Zend_Db::FETCH_OBJ);
            $res = $res->fetchAll();
            $this->_helper->viewRenderer('view');
        }
        else {
            $this->_helper->viewRenderer('index');
        }
        $this->view->catalog = $res;
    }


}



