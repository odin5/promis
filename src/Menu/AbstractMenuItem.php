<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 23.08.2018 12:25
 */

namespace App\Menu;


abstract class AbstractMenuItem
{
    /**
     * Since Twig is not able to compare types of instances (a.k.a instanceof operator), descendants need to provide
     * their unique string. Probably the class name itself.
     * @return string Constant string identifying descendant of AbstractMenuItem
     */
    public abstract function getType(): string;

    /**
     * @var string Menu item identifier, mainly used for recognizing and marking active item
     */
    protected $id;
    protected $label;
    protected $cssClass;
    protected $liCssClass;

    public function __construct(string $id, $label = null)
    {
        $this->id = $id;
        $this->label = $label;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getCssClass(): ?string
    {
        return $this->cssClass;
    }

    public function setCssClass($cssClass)
    {
        $this->cssClass = $cssClass;
        return $this;
    }

    public function getLiCssClass(): ?string
    {
        return $this->liCssClass;
    }

    public function setLiCssClass($liCssClass)
    {
        $this->liCssClass = $liCssClass;
        return $this;
    }
}