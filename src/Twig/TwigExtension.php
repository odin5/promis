<?php

namespace App\Twig;

use App\Service\PageManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TwigExtension extends \Twig_Extension
{
    private $container;
    private $pageManager;

    public function __construct(ContainerInterface $container, PageManager $pageManager)
    {
        $this->container = $container;
        $this->pageManager = $pageManager;
    }

    public function getName()
    {
        return 'app_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('md5', 'md5'),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getHelpPageForCurrentRoute', [$this->pageManager, 'getHelpPageForCurrentRoute']),
            new \Twig_SimpleFunction('getSupportedLocales', [$this, 'getSupportedLocales']),
        );
    }

    public function getTests()
    {
        return array(
            new \Twig_SimpleTest('numeric', [$this, 'numericTest']),
        );
    }

    public function getSupportedLocales()
    {
        return $this->container->getParameter('locales_array');
    }

    public function numericTest($string)
    {
        return is_numeric($string);
    }
}