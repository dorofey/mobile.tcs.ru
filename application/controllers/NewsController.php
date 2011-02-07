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
            $this->_news->select()->limit(15)->order('news_date DESC')
        );
        $this->view->news = $res;
    }


    public function viewAction()
    {
        $res = $this->_news->fetchRow(
            $this->_news->select()->where('news_id = ?', $this->_getParam('id'))
        );
        
        if(count($res) == 0) $this->_redirect('/news/_404_');

        $res->news_smalltext = str_replace('src="/i/', 'src="http://tcs.ru/i/', $res->news_smalltext);
        $res->news_longtext = str_replace('src="/i/', 'src="http://tcs.ru/i/', $res->news_longtext);
        $this->view->news = $res;
    }
    public function errorAction(){
        $this->view->message = 'Такой новости не существует' ;
    }

}

