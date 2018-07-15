<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 10.07.2018
 * Time: 16:40
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=254, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=254,)
     */
    private $roles;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->roles = 'ROLE_STUDENT';
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
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
    
    public function getId(): ?int
    {
         return $this->id;
    }
    
    public function setUsername(string $username): self
    {
         $this->username = $username;
         
         return $this;
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
}