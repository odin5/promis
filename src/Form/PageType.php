<?php

namespace App\Form;

use App\Entity\Page;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class PageType extends AbstractType
{
    /** @var ContainerInterface */
    private $router;
    private $translator;

    public function __construct(RouterInterface $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $actions = [];
        foreach($this->router->getRouteCollection() as $route) {
            $action = $route->getDefault('_controller');
            $routeName = $route->getDefault('_canonical_route');
            if(empty($action)) continue;
            if(dirname($action) != 'App\\Controller') continue;
            $httpMethods = $route->getMethods();
            if(!empty($httpMethods) && !in_array('GET', $route->getMethods())) continue;
            $actions[$action][$routeName][] = $route->getPath();
        }
        ksort($actions);
        $choices = [
            $this->translator->trans('Speciální stránka "Skripta"') => 'lecture',
        ];
        foreach($actions as $action => $routes) {
            $routesConcat = '';
            ksort($routes);
            foreach($routes as $route => $paths) {
                if(!empty($routesConcat)) $routesConcat .= '; ';
                if(!empty($route)) $routesConcat .= $route .': ';
                $routesConcat .= implode(', ', $paths);
            }
            $choices["$action ($routesConcat)"] = $action;
        };

        $builder
            ->add('translations', TranslationsType::class, [
                'label' => false,
                'fields' => [
                    'content' => [
                        'field_type' => CKEditorType::class,
                    ],
                    'path' => [
                        'label' => 'URL stránky'
                    ],
                ]
            ])
            ->add('appPages', ChoiceType::class, [
                'choices' => $choices,
                'multiple' => true,
                'required' => false,
                'label' => 'Přiřadit k následujícím stránkám jako nápovědu',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
