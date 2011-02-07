<?php

class NewsController extends Zend_Controller_Action
{
    /**
     * @var Application_Model_DbTable_News
     */
    private $_news;
    protected $layout;

    public function init()
    {
        $this->_news = new Application_Model_DbTable_News();
        $this->layout = Zend_Layout::getMvcInstance();
        $this->_helper->layout()->home = '/news/';
    }

    public function indexAction()
    {
        $this->_helper->layout()->home = '/';

        $res = $this->_news->fetchAll(
            $this->_news->select()->limit(15)->order('dateadded DESC')
        );
        $this->view->news = $res;
    }


    public function viewAction()
    {
        $res = $this->_news->fetchRow(
            $this->_news->select()->where('id = ?', $this->_getParam('id'))
        );
        
        if(count($res) == 0) $this->_redirect($this->view->url(array(),'newsNotFound'));

        $res->smalltext = str_replace('src="/i/', 'src="http://tcs.ru/i/', $res->smalltext);
        $res->longtext = str_replace('src="/i/', 'src="http://tcs.ru/i/', $res->longtext);
        $this->view->news = $res;
    }
    public function errorAction(){
        $this->view->message = 'Такой новости не существует' ;
    }

}

