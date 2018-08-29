<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 10.07.2018 16:40
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ApiResource(
 *     iri="/projects/translations",
 *     collectionOperations={},
 *     itemOperations={
 *         "get"={ "path"="/projects/translations/{id}"}
 *     }
 * )
 */
class ProjectTranslation
{
    use Translation;

    /* @var $attachmentRepository ObjectRepository */
    private static $attachmentRepository;

    /**
     * (In form as 'Název')
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank()
     * @Groups({"Project_read"})
     */
    private $name;

    /**
     * (In form as 'Perex')
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Project_read"})
     */
    private $perex;

    /**
     * (In form as 'Popis')
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Project_read"})
     */
    private $description = '';


    public static function setAttachmentRepository(ObjectRepository $repo)
    {
        self::$attachmentRepository = $repo;
    }

    public function getFormattedDescription()
    {
        if(!self::$attachmentRepository) return $this->description;
        $replaceHandler = function($matches) {
            if(is_numeric($matches[2])) $attachment = self::$attachmentRepository->findOneBy(['id' => $matches[2]]);
            /* @var $attachment Attachment */
            else $attachment = self::$attachmentRepository->findOneByName($matches[2]);
            if(!empty($attachment)) {
                switch ($matches[1]) {
                    case 'IMG': return '<img src="' . htmlspecialchars($attachment->getPath())
                                            . '" alt="' . htmlspecialchars($attachment->getName()) . '" />';
                    case 'LINK': return '<a href="' . htmlspecialchars($attachment->getPath()) . '">'
                                            . htmlspecialchars($matches[3]) . '</a>';
                }
            }
            return $matches[0];// return original text
        };
        return preg_replace_callback('/(IMG|LINK)\[(\w*)\|([\w ]*)\]/', $replaceHandler, $this->description);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPerex(): ?string
    {
        return $this->perex;
    }

    public function setPerex(string $perex): self
    {
        $this->perex = $perex;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


}