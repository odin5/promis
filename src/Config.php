<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 13.07.2018
 * Time: 15:13
 */

namespace App;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Config is meant to provide access to some of configuration values, for example for case, where classic
 * Symfony parameter cannot be accessed (like an PHPDoc annotation, or Entity)
 */
class Config
{
    /* @var $container ContainerInterface */
    private static $container = null;

    /* @var $requestLocale string */
    private static $requestLocale = null;

    public static function setContainer(ContainerInterface $container)
    {
        self::$container = $container;
    }
    public static function setRequestLocale(string $requestLocale)
    {
        self::$requestLocale = $requestLocale;
    }

    public static function getRequestLocale()
    {
        return self::$requestLocale;
    }
    public static function getDefaultLocale()
    {
        return self::$container->getParameter('locale');
    }

    public static function getRootPath()
    {
        return self::$container->getParameter('kernel.root_dir');
    }
    public static function getPublicPath()
    {
        return self::getRootPath() .'/public';
    }
    public static function getUploadPath($for = null)
    {
        $dir = self::getPublicPath() .'/'. self::$container->getParameter('uploads_dir');
        if($for && self::$container->hasParameter($for .'_subdir')) {
            $dir .= '/'. self::$container->getParameter($for .'_subdir');
        }
        return $dir;
    }

    public static function getUploaderHelper()
    {
        return self::$container->get(\Vich\UploaderBundle\Templating\Helper\UploaderHelper::class);
    }
}