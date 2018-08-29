<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 12.07.2018
 * Time: 14:01
 */

namespace App\Api\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;

class KernelSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => [
                ['fixTranslationIndicies', 100],
            ],
        ];
    }

    public function fixTranslationIndicies(GetResponseForControllerResultEvent $event)
    {
        if(!$event->getRequest()->attributes->has('_api_resource_class')) return;
        $className = $event->getRequest()->attributes->get('_api_resource_class');
        if(is_array($event->getControllerResult())) {
            foreach($event->getControllerResult() as $item) $this->doFixTranslationIndicies($item, $className);
        }
        else $this->doFixTranslationIndicies($event->getControllerResult(), $className);
    }
    private function doFixTranslationIndicies($obj, $cls)
    {
        if(!is_object($obj) || !($obj instanceof $cls) || !method_exists($obj, 'getTranslations')) return;
        $ts = $obj->getTranslations();
        if(!is_array($ts) && !(is_object($ts) && $ts instanceof \Traversable && $ts instanceof \ArrayAccess)) return;
        $orig = iterator_to_array($ts);
        foreach($ts as $key => $value) {
            unset($ts[$key]);
            $ts[] = $orig[$key];
        }
    }

}