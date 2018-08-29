<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 26.07.2018 23:56
 */

namespace App\Entity;


use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Příloha - obrazky pro prilohy
 * @ORM\Entity(repositoryClass="App\Repository\AttachmentRepository")
 * @Vich\Uploadable
 */
class Attachment
{
    use Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Projekt')
     * @ORM\ManyToOne(targetEntity="Project")
     */
    private $project;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * (In form as 'Soubor')
     * @Vich\UploadableField(mapping="attachment", fileNameProperty="filename")
     * @Assert\File(maxSize = "10Mi")
     * @var File
     */
    private $fileUpload;

    public function __toString()
    {
        return (string)$this->getName();
    }

    public function getName()
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): AttachmentTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getPath(): ?string
    {
        return \App\Config::getUploaderHelper()->asset($this, 'attachment');
    }

    public function getFileUpload(): ?File
    {
        return $this->fileUpload;
    }

    public function setFileUpload(File $fileUpload): self
    {
        $this->fileUpload = $fileUpload;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

}