<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 25.07.2018 16:13:
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;

/**
 * Škola
 * @ApiResource(
 *     attributes={"order"={"name"}},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"access_control"="is_granted('ROLE_SUPER_ADMIN') or object in user.allowedProjectEdits)"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="(is_granted('ROLE_ADMIN') or object in user.allowedProjects)"},
 *         "put"={"access_control"="is_granted('ROLE_ADMIN') or object in user.allowedProjectEdits"}
 *     }
 * )
 * @ORM\Entity
 */
class School
{
    use Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * (In form as 'Škola')
     * @ORM\OneToMany(targetEntity="User", mappedBy="school")
     */
    private $students;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function __toString()
    {
        return (string)$this->getName();
    }
    /**
     * @ApiProperty(iri="http://schema.org/name")
     */
    public function getName(): string
    {
        return $this->proxyCurrentLocaleTranslation('getName');
    }

    public function translate($locale = null, $fallbackToDefault = true): SchoolTranslation
    {
        return $this->doTranslate($locale, $fallbackToDefault);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(User $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setSchool($this);
        }

        return $this;
    }

    public function removeStudent(User $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getSchool() === $this) {
                $student->setSchool(null);
            }
        }

        return $this;
    }

}