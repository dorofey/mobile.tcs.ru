<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initRoute() {
        /**
         * @var Zend_Controller_Router_Rewrite
         */
        $router = Zend_Controller_Front::getInstance()->getRouter();

        $router->addRoute('newsItem', new Zend_Controller_Router_Route('/news/:id', array(
            'controller' => 'news',
            'action' => 'view'))
        );
        $router->addRoute('newsNotFound', new Zend_Controller_Router_Route('/news/_404_', array(
            'controller' => 'news',
            'action' => 'error'))
        );
        $router->addRoute('catalogCatalog', new Zend_Controller_Router_Route('/catalog/:id', array(
            'controller' => 'catalog',
            'action' => 'view'))
        );
        $router->addRoute('prodictsList', new Zend_Controller_Router_Route('/products/:id', array(
            'controller' => 'products',
            'action' => 'list'))
        );
        $router->addRoute('prodictsListJSON', new Zend_Controller_Router_Route('/products/:id/json', array(
            'controller' => 'products',
            'action' => 'list',
            'json'=>true))
        );
        $router->addRoute('prodictView', new Zend_Controller_Router_Route('/product/:id', array(
            'controller' => 'products',
            'action' => 'view'))
        );
    }
}

