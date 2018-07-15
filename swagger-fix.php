<?php
$services = file_get_contents(__DIR__ .'/src/RestBundle/Resources/config/services.yml');
$services = preg_replace('/:\s*(%[^%]+%)/', ': \'$1\'', $services);
//$services = preg_replace('/^(\s+)(class: .+\\\\Controller\\\\.+Controller)/', '$1$2\n$1tags: [\'controller.service_arguments\']', $services);
$services = preg_replace('/^(\s+)(class: .+\\\\Controller\\\\.+Controller)$/m', '$1$2
$1tags: [\'controller.service_arguments\']', $services);
file_put_contents(__DIR__ .'/src/RestBundle/Resources/config/services.yml', $services);

echo "\n>> Generated service.yml fixed";

$controller = file_get_contents(__DIR__ .'/src/RestBundle/Controller/Controller.php');
$controller = str_replace('class Controller', 'class Controller extends \Symfony\Bundle\FrameworkBundle\Controller\Controller', $controller);
$controller = str_replace('$accept = preg_split("/[\s,]+/", $accept);', '$accept = preg_split("/[\s,;]+/", $accept);', $controller);
file_put_contents(__DIR__ .'/src/RestBundle/Controller/Controller.php', $controller);

echo "\n>> Generated Controller.php fixed";

//$bundle = file_get_contents(__DIR__ .'/src/RestBundle/RestBundleBundle.php');
//$bundle = str_replace('class RestBundleBundle', 'class RestBundle', $bundle);
//file_put_contents(__DIR__ .'/src/RestBundle/RestBundleBundle.php', $bundle);
//rename(__DIR__ .'/src/RestBundle/RestBundleBundle.php', __DIR__ .'/src/RestBundle/RestBundle.php');
//
//echo "\n>> Generated RestBundleBundle.php fixed (changed name to RestBundle.php)";