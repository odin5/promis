<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 22.08.2018 18:19
 */
namespace App\Menu;

class LinkItem extends AbstractMenuItem
{
    protected $icon;
    protected $iconHtml;
    protected $link;
    protected $active = false;

    public function getType(): string
    {
        return 'LinkItem';
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;
        return $this;
    }

    public function getIconHtml(): ?string
    {
        return $this->iconHtml;
    }

    public function setIconHtml($iconHtml): self
    {
        $this->iconHtml = $iconHtml;
        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink($link): self
    {
        $this->link = $link;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

}