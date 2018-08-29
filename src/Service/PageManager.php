<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 16.07.2018
 * Time: 9:38
 */

namespace App\Service;

use App\Entity;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class PageManager
{
    private $requestStack;
    private $router;
    private $em;

    public function __construct(RequestStack $requestStack, RouterInterface $router, ObjectManager $em)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->em = $em;
    }

    public function getHelpPageForCurrentRoute(): ?Entity\Page
    {
        if(!($routeName = $this->requestStack->getMasterRequest()->attributes->get('_route'))) return null;
        $route = null;
        foreach($this->router->getRouteCollection()->all() as $key => $value) {
            if(explode('.', $key)[0] === $routeName) $route = $value;
        };
        if(!$route) return null;
        if(!($action = $route->getDefault('_controller'))) return null;
        return $this->em->getRepository(Entity\Page::class)->findOneForAppPage($action);
    }
}