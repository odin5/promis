<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 22.08.2018 11:27
 */

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Translation\TranslatorInterface;

abstract class AbstractController extends Controller
{

    /**
     * @var ObjectManager
     */
    protected $em;
    /**
     * @var TranslatorInterface
     */
    protected $trans;

    public function __construct(ObjectManager $em, TranslatorInterface $trans)
    {
        $this->em = $em;
        $this->trans = $trans;
    }

    protected function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->trans->trans($id, $parameters, $domain, $locale);
    }

    protected function transChoice($id, $number, array $parameters = [], $domain = null, $locale = null)
    {
        return $this->trans->transChoice($id, $number, $parameters, $domain, $locale);
    }
}