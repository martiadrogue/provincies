<?php

namespace Com\Martiadrogue\Provincies\Controller;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\HtmlResponse;

class ProvinciesController extends BaseController
{
    private $rootTemplate = '../view/';
    private $cacheTemplate = '../cache/template';

    public function __construct()
    {
        # code...
    }

    protected function getMenuLinks()
    {
        return array('links' => [
            'root' => 'http://'.$this->getHttpHost(),
            'about' => 'http://'.$this->getHttpHost().'/about',
            'contact' => 'http://'.$this->getHttpHost().'/contact',
            'search' => 'http://'.$this->getHttpHost().'/provincia/',
            'provincia' => 'http://'.$this->getHttpHost().'/provincia/',
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
}
