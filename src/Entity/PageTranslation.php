<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 01.08.2018 16:49
 */

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class PageTranslation
{
    use Translation;

    /**
     * @var string
     *
     * @ORM\Column(unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[^\/][\w\/\-]+$/i")
     * @Assert\Length(max=255)
     */
    protected $path;
    /**
     * @var string
     *
     * @ORM\Column()
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    protected $title;
    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $content;

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return (string)$this->title;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

}