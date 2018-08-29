<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 22.08.2018 18:19
 */
namespace App\Menu;

class GroupItem extends AbstractMenuItem implements \IteratorAggregate
{
    protected $items = [];
    protected $notShowLabelIfFirstItem = false;
    protected $collapsible = true;
    protected $collapsed = false;

    public function getType(): string
    {
        return 'GroupItem';
    }

    public function getIterator() {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array $items
     */
    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param array $items
     */
    public function addItem(AbstractMenuItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * @return bool
     */
    public function isNotShowLabelIfFirstItem(): bool
    {
        return $this->notShowLabelIfFirstItem;
    }

    /**
     * @param bool $notShowLabelIfFirstItem
     * @return GroupItem
     */
    public function setNotShowLabelIfFirstItem(bool $notShowLabelIfFirstItem)
    {
        $this->notShowLabelIfFirstItem = $notShowLabelIfFirstItem;
        return $this;
    }
//
//    /**
//     * @return mixed
//     */
//    public function isCollapsible()
//    {
//        return $this->collapsible;
//    }
//
//    /**
//     * @param mixed $collapsible
//     */
//    public function setCollapsible($collapsible)
//    {
//        $this->collapsible = $collapsible;
//        return $this;
//    }
//
//    /**
//     * @return bool
//     */
//    public function isCollapsed(): bool
//    {
//        return $this->collapsed;
//    }
//
//    /**
//     * @param bool $collapsed
//     */
//    public function setCollapsed(bool $collapsed)
//    {
//        $this->collapsed = $collapsed;
//        return $this;
//    }
}