<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 12.07.2018
 * Time: 14:01
 */

namespace App\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class SecuritySubscriber implements EventSubscriberInterface
{
    private $em;
    public function __construct(EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => [
                ['onSuccessfulLogin'],
            ],
        ];
    }

    public function onSuccessfulLogin(InteractiveLoginEvent $event)
    {
        $event->getAuthenticationToken()->getUser()->setLastLogin(new \DateTime());
        $this->em->flush();
    }
}