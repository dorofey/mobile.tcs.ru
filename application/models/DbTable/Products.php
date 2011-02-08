<?php

class Application_Model_DbTable_Products extends Zend_Db_Table_Abstract
{

    protected $_name = 'prod_temp';

    public function getFullProduct($id){

        $joins = array(
            array('new_products_2', '1c_id', 'prod_uniq'),
//            array('prod_new', 'new_cid', 'prod_uniq'),
        );

        $select = $this
                ->select($this->_name)
                ->setIntegrityCheck(false)
                ->where($this->_name . '.prod_uniq = ?', $id)
                ->limit(1);
        foreach($joins as $join) {
            $select->joinLeft(
                $join[0],
                sprintf('`%s`.`%s` = `%s`.`%s`', $join[0], $join[1], $this->_name, $join[2])
            );

        }
        $this->getAdapter()->setFetchMode(Zend_Db::FETCH_OBJ);
        $res = $this->getAdapter()->fetchRow($select);

        return $res;
    }
    public function getProductQuantity($id) {
        $adapter = $this->getAdapter();
        $select = $this->getAdapter()->select()
                ->from(array('q'=>'prod_quantities'),
                       array('branch'=>'prod_branch',
                             'quantity'=>'prod_quantity'))
                ->where('prod_id = ?', $id);

        $adapter->setFetchMode(Zend_Db::FETCH_OBJ);

        $res = $adapter->fetchAll($select);

        return $res;
    }
}

