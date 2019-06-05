<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\View\View;
use Zend\View\ViewEvent;

final class controllerRequestResponseDynamicReturn extends AbstractActionController
{
    public function actionIndex()
    {
        $this->getRequest()->getBasePattt();
        $this->getResponse()->headersSenttt();

        $this->getRequest()->getBasePath();
        $this->getRequest()->isPost();
        $this->getResponse()->headersSent();
        $this->getResponse()->getStatusCode();
    }

    private function foo(MvcEvent $event)
    {
        $event->getRequest()->getBasePattt();
        $event->getResponse()->headersSenttt();

        $event->getRequest()->getBasePath();
        $event->getRequest()->isPost();
        $event->getResponse()->headersSent();
        $event->getResponse()->getStatusCode();

        $event->getApplication()->getRequest()->getBasePattt();
        $event->getApplication()->getResponse()->headersSenttt();

        $event->getApplication()->getRequest()->getBasePath();
        $event->getApplication()->getRequest()->isPost();
        $event->getApplication()->getResponse()->headersSent();
        $event->getApplication()->getResponse()->getStatusCode();
    }

    private function bar(View $view)
    {
        $view->getRequest()->getBasePattt();
        $view->getResponse()->headersSenttt();

        $view->getRequest()->getBasePath();
        $view->getRequest()->isPost();
        $view->getResponse()->headersSent();
        $view->getResponse()->getStatusCode();
    }

    private function baz(ViewEvent $viewEvent)
    {
        $viewEvent->getRequest()->getBasePattt();
        $viewEvent->getResponse()->headersSenttt();
        $viewEvent->getRenderer()->getEngineee();

        $viewEvent->getRequest()->getBasePath();
        $viewEvent->getRequest()->isPost();
        $viewEvent->getResponse()->headersSent();
        $viewEvent->getResponse()->getStatusCode();
        $viewEvent->getRenderer()->getEngine();
    }
}
