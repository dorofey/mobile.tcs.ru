<?php

class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'prod_temp';

    public function getFullProduct($id){

        $joins = 'new_products_2';

        $select = $this
                ->select($this->_name)
                ->setIntegrityCheck(false)
                ->joinLeft($joins, $joins.'.`1c_id` = ' . $this->_name . '.prod_uniq')
                ->where($this->_name . '.prod_uniq = ?', $id)
                ->limit(1);
        $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $res = $this->getAdapter()->fetchRow($select);
        return $res;
    }

}

