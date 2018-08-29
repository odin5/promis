<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 17.08.2018 10:42
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity;

class PageController extends AbstractController
{
    /**
     * @Route("/p/{path}", requirements={"path"=".+"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(string $path = '', $_locale): Response
    {
        /** @var Entity\PageTranslation[] $pageTranslation */
        $pageTranslation = $this->getDoctrine()->getRepository(Entity\PageTranslation::class)
            ->findBy(['path' => $path]);
        if (empty($pageTranslation)) throw $this->createNotFoundException(sprintf('Page not found for path "/%s".', $path));
        elseif(count($pageTranslation) === 0) $pageTranslation = reset($pageTranslation);
        else {
            foreach($pageTranslation as $pt) {
                if($pt->getLocale() === $_locale) {
                    $pageTranslation = $pt;
                    break;
                }
            }
            if(is_array($pageTranslation)) $pageTranslation = reset($pageTranslation);
        }
        return $this->render('page/show.html.twig', ['page' => $pageTranslation->getTranslatable()]);
    }
}