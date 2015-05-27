<?php

namespace Com\Martiadrogue\Provincies\Controller\Admin;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\HtmlResponse;
use Com\Martiadrogue\Provincies\Common\SessionHandler;

class AdminController extends BaseController
{
    private $rootTemplate = '../view/admin';
    private $cacheTemplate = '../cache/template';

    public function __construct()
    {
        # code...
    }

    protected function getMenuLinks()
    {
        return array('links' => [
            'root' => 'http://'.$this->getHttpHost() . '/et6tdkjvjo/provincies',
            'provincies' => 'http://'.$this->getHttpHost() . '/et6tdkjvjo/provincies',
            'municipis' => 'http://'.$this->getHttpHost().'/et6tdkjvjo/municipis',
            'usuaris' => 'http://'.$this->getHttpHost().'/et6tdkjvjo/usuaris',
            'logout' => 'http://'.$this->getHttpHost().'/et6tdkjvjo/usuaris/logout',
        ]);
    }

    protected function getHttpHost()
    {
        $request = parent::getService('request');

        return $request->getHttpHost();
    }

    protected function render($path, Array $data)
    {
        $template = parent::getService('twig');
        $template->setTemplateHome($this->rootTemplate);
        $template->setCacheHome($this->cacheTemplate);
        $template->loadTemplate($path);
        $canvas = $template->paint($data);

        return new HtmlResponse($canvas, 200);
    }

    protected function checkSession()
    {
        $request = parent::getService('request');
        $ipClient = $request->getClientAddresses();
        $sessionHandler = new SessionHandler($request->getSession(), $ipClient);

        return $sessionHandler->checkSession();
    }

    protected function getUserNameFromSession()
    {
        $request = parent::getService('request');
        $ipClient = $request->getClientAddresses();
        $sessionHandler = new SessionHandler($request->getSession(), $ipClient);

        return $sessionHandler->getSessionData(SessionHandler::USER_TAG);
    }
}
