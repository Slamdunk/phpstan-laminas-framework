<?php

declare(strict_types=1);

namespace ZendPhpStan\Tests\ZendIntegration\data;

use Zend\Mvc\Controller\AbstractActionController;

final class controllerRequestResponseDynamicReturn extends AbstractActionController
{
    public function actionIndex()
    {
        // $this->request->getBasePattt();
        $this->getRequest()->getBasePattt();
        // $this->response->headersSenttt();
        $this->getResponse()->headersSenttt();

        // $this->request->getBasePath();
        $this->getRequest()->getBasePath();
        // $this->request->isPost();
        $this->getRequest()->isPost();
        // $this->response->headersSent();
        $this->getResponse()->headersSent();
        // $this->response->getStatusCode();
        $this->getResponse()->getStatusCode();
    }
}
