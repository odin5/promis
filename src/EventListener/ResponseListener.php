<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 12.07.2018
 * Time: 14:01
 */

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class ResponseListener
{
    private $appEnviroment;

    public function __construct(string $appEnviroment)
    {
        $this->appEnviroment = $appEnviroment;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if($this->appEnviroment === 'prod') $this->minifyHtmlResponse($event);
    }

    private function minifyHtmlResponse(FilterResponseEvent $event) {
        $response = $event->getResponse();
        if (!$event->isMasterRequest() or ! in_array($event->getRequest()->getRequestFormat(), array("html", "xml"))) {
            return;
        }
        $parser = \WyriHaximus\HtmlCompress\Factory::construct();
        $compressedContent = $parser->compress($response->getContent());
        $response->setContent($compressedContent);
    }
}