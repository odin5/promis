<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Uživatel
 * @ApiResource(
 *     attributes={"order"={"lastname","firstname"}},
 *     normalizationContext={"groups"={"User_read"}, "swagger_definition_name"="User_read"},
 *     denormalizationContext={"groups"={"User_write"}, "swagger_definition_name"="User_write"},
 *     collectionOperations={
 *         "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *         "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     },
 *     itemOperations={
 *         "get"={"access_control"="(is_granted('ROLE_ADMIN') or object == user)"},
 *         "put"={"access_control"="is_granted('ROLE_ADMIN')"}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"User_read", "User_write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Groups({"User_read", "User_write"})
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Groups({"User_read", "User_write"})
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * Comma-separated list of roles
     * @ORM\Column(type="string", length=254)
     */
    private $roles;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"User_read", "User_write"})
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"User_read", "User_write"})
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"User_read", "User_write"})
     */
    private $lastLogin;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"User_read", "User_write"})
     */
    private $dateJoined;

    /**
     * ID number in terms of school (UČO) (In form as 'Id. číslo')
     * @ORM\Column(type="string", length=10)
     * @Groups({"User_read", "User_write"})
     */
    private $id_number = '';

    /**
     * (In form as 'Kontakty')
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Groups({"User_read", "User_write"})
     */
    private $contacts;

    /**
     * (In form as 'Kurz')
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Groups({"User_read", "User_write"})
     */
    private $course;

    /**
     * (In form as 'Dostupné projekty')
     * @ORM\ManyToMany(targetEntity="App\Entity\Project")
     * @ORM\JoinTable(name="user_project_use",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     * @Groups({"User_read", "User_write"})
     */
    private $allowedProjects;

    /**
     * (In form as 'Editovatelné projekty')
     * @ORM\ManyToMany(targetEntity="App\Entity\Project")
     * @ORM\JoinTable(name="user_project_edit",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     * @Groups({"User_read", "User_write"})
     */
    private $allowedProjectEdits;

    /**
     * (In form as 'Škola')
     * @ORM\ManyToOne(targetEntity="School", inversedBy="students")
     * @ORM\JoinColumn(name="school_id", referencedColumnName="id", nullable=true)
     * @Groups({"User_read", "User_write"})
     */
    private $school = null;

    public function __construct()
    {
        $this->isActive = true;
        $this->roles = 'ROLE_STUDENT';
        $this->dateJoined = new \DateTime('now');
        $this->allowedProjects = new ArrayCollection();
        $this->allowedProjectEdits = new ArrayCollection();

    }

    public function isProjectEditor()
    {
        return $this->allowedProjectEdits->count() > 0;
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @ORM\PrePersist
     */
    public function setDateJoined(): self
    {
        $this->dateJoined = new \DateTime();

        return $this;
    }
    
    public function getId(): ?int
    {
         return $this->id;
    }


    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
         $this->username = $username;
         
         return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword(string $password): self
    {
         $this->password = $password;
         
         return $this;
    }
    
    public function getEmail(): ?string
    {
         return $this->email;
    }
    
    public function setEmail(string $email): self
    {
         $this->email = $email;
         
         return $this;
    }
    
    public function isActive(): ?bool
    {
         return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
         $this->isActive = $isActive;
         
         return $this;
    }


    public function getRoles()
    {
        return explode(',', $this->roles);
    }

    public function setRoles(array $roles): self
    {
        $roles = array_filter($roles, function($r) { return false === strpos($r,','); });
        $this->roles = implode(',', $roles);

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setLastLogin(\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    public function getDateJoined(): ?\DateTimeInterface
    {
        return $this->dateJoined;
    }

    public function getIdNumber(): ?string
    {
        return $this->id_number;
    }

    public function setIdNumber(string $id_number): self
    {
        $this->id_number = $id_number;

        return $this;
    }

    public function getContacts(): ?string
    {
        return $this->contacts;
    }

    public function setContacts(?string $contacts): self
    {
        $this->contacts = $contacts;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(?string $course): self
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getAllowedProjects(): Collection
    {
        return $this->allowedProjects;
    }

    public function addAllowedProject(Project $allowedProject): self
    {
        if (!$this->allowedProjects->contains($allowedProject)) {
            $this->allowedProjects[] = $allowedProject;
        }

        return $this;
    }

    public function removeAllowedProject(Project $allowedProject): self
    {
        if ($this->allowedProjects->contains($allowedProject)) {
            $this->allowedProjects->removeElement($allowedProject);
        }

        return $this;
    }

    /**
     * @return Collection|Project[]
     */
    public function getAllowedProjectEdits(): Collection
    {
        return $this->allowedProjectEdits;
    }

    public function addAllowedProjectEdit(Project $allowedProjectEdit): self
    {
        if (!$this->allowedProjectEdits->contains($allowedProjectEdit)) {
            $this->allowedProjectEdits[] = $allowedProjectEdit;
        }

        return $this;
    }

    public function removeAllowedProjectEdit(Project $allowedProjectEdit): self
    {
        if ($this->allowedProjectEdits->contains($allowedProjectEdit)) {
            $this->allowedProjectEdits->removeElement($allowedProjectEdit);
        }

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}