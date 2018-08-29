<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 */

namespace App\Repository;

use App\Config;
use App\Entity\AttachmentTranslation;
use App\Entity\Attachment;
use Doctrine\ORM\NoResultException;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;

class AttachmentRepository extends BaseRepository
{

    public function findOneByName(string $name, $onlyCurrentLocale = false): ?Attachment
    {
        try {
            $trans = $this->getEntityManager()
                ->getRepository(AttachmentTranslation::class)
                ->findBy(['name' => $name]);
            $forCurrentLocale = array_filter($trans, function($t) { return $t->getLocale() === Config::getRequestLocale(); });
            if(!empty($forCurrentLocale)) $result = reset($forCurrentLocale)->getTranslatable();
            elseif(!$onlyCurrentLocale && !empty($trans)) $result = reset($trans)->getTranslatable();
            else $result = null;
        } catch(NoResultException $e) {
            return null;
        }
        return $result;
    }
}
