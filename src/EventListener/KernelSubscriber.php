<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 12.07.2018
 * Time: 14:01
 */

namespace App\EventListener;

use App\Entity;
use App\Service\StateManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerArgumentsEvent;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelSubscriber implements EventSubscriberInterface
{
    private $container;
    private $appEnvironment;
    private $entityManager;
    private $requestStack;
    private $state;
    public function __construct(ContainerInterface $container, string $appEnvironment, EntityManagerInterface $entityManager,
                                RequestStack $requestStack, StateManager $state
    ) {
        $this->container = $container;
        $this->appEnvironment = $appEnvironment;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
        $this->state = $state;
    }

    public static function getSubscribedEvents()
    {
        return [
            ConsoleEvents::COMMAND => [
                ['doStuffAtTheBeginning', 1000],
            ],
            KernelEvents::REQUEST => [
                ['doStuffAtTheBeginning', 1000],
            ],
            KernelEvents::CONTROLLER_ARGUMENTS => [
                ['captureSomeControllerArguments', 1000],
            ],
            KernelEvents::RESPONSE => [
                ['minifyHtmlResponseOnProd', -1000],
            ],
//            KernelEvents::CONTROLLER => [
//                ['processAnnotations', 0],
//            ],
        ];
    }

    public function doStuffAtTheBeginning()
    {
        \App\Config::setContainer($this->container);
        if(!empty($this->requestStack->getCurrentRequest())) {
            \App\Config::setRequestLocale($this->requestStack->getCurrentRequest()->getLocale());
        }
        else \App\Config::setRequestLocale(\App\Config::getDefaultLocale());
        Entity\ProjectTranslation::setAttachmentRepository($this->entityManager->getRepository(Entity\Attachment::class));
    }

    public function captureSomeControllerArguments(FilterControllerArgumentsEvent $event)
    {
        $callable = $event->getController();
        if(is_array($callable) && is_object(reset($callable))) {
            if((new \ReflectionClass(reset($callable)))->getNamespaceName() === 'App\\Contoller\\Admin') {
                $this->state['isAdministration'] = true;
            }
        }

        if(!$this->state->get('isAdministration', false)) {
            $plans = array_filter($event->getArguments(), function ($a) { return $a instanceof Entity\Plan; });
            if(count($plans) === 1) $this->state['currentPlan'] = reset($plans);

            $projects = array_filter($event->getArguments(), function ($a) { return $a instanceof Entity\Project; });
            if(count($projects) === 1) {
                $this->state['currentProject'] = reset($projects);
                if($this->requestStack->getMasterRequest()->getSession()->has('plan')) {
                    $this->state['currentPlan'] = $this->requestStack->getMasterRequest()->getSession()->get('plan');
                }
            }
            elseif(count($projects) === 0) {
                if($this->state->has('currentPlan')) {
                    $this->state['currentProject'] = $this->state['currentPlan']->getPlayersProject()->getProject();
                }
            }
        }
    }

    public function minifyHtmlResponseOnProd(FilterResponseEvent $event)
    {
        if($this->appEnvironment === 'prod') {
            $response = $event->getResponse();
            if (!$event->isMasterRequest() or !in_array($event->getRequest()->getRequestFormat(), array("html", "xml"))) {
                return;
            }
            $parser = \WyriHaximus\HtmlCompress\Factory::construct();
            $compressedContent = $parser->compress($response->getContent());
            $response->setContent($compressedContent);
        }
    }
}