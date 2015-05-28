<?php

namespace Com\Martiadrogue\Provincies\Controller;

use Com\Martiadrogue\Mpwarfwk\Controller\BaseController;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\HtmlResponse;
use Com\Martiadrogue\Mpwarfwk\Cache\MemoryCache;
use Com\Martiadrogue\Mpwarfwk\Cache\DiskCache;

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
        $response = new HtmlResponse($canvas, 200);
        $this->addCache($response);

        return $response;
    }

    private function addCache($response)
    {
        $request = parent::getService('request');
        $cache = new MemoryCache();
        $hash = md5($request->getUri());
        $cache->set($hash, serialize($response), 120);
    }

    protected function getModelCache($key)
    {
        $cache = new DiskCache();
        $hash = md5($key);

        return unserialize($cache->get($hash));
    }

    protected function addModelCache($key, $data)
    {
        $cache = new DiskCache();
        $hash = md5($key);
        $cache->set($hash, serialize($data), null);
    }

}
