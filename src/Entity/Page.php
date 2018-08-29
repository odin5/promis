<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 14:47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    use Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $appPages;

    public function __toString()
    {
        return $this->getTitle();
    }

    public function getPath()
    {
        return $this->proxyCurrentLocaleTranslation('getPath');
    }

    public function getTitle()
    {
        return $this->proxyCurrentLocaleTranslation('getTitle');
    }

    public function getContent()
    {
        return $this->proxyCurrentLocaleTranslation('getContent');
    }

    public function translate($locale = null, $fallbackToDefault = true): PageTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppPages(): ?array
    {
        return $this->appPages ?: [];
    }

    public function setAppPages(array $appPages): self
    {
        $this->appPages = $appPages;

        return $this;
    }

}