<?php
/**
 * Created by PhpStorm.
 * User: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Date: 10.07.2018
 * Time: 16:40
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectRepository")
 */
class Project implements Translatable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text")
     */
    private $description;

    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
}