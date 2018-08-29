<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 23.08.2018 11:15
 */

namespace App\Service;
use App\Event\StateManagerChangedEvent;

/**
 * Class StateManager
 * @package App\Service
 */
class StateManager implements \ArrayAccess
{
    private $listeners = [];
    public $storage = [];

    public function has($key): bool
    {
        return array_key_exists($key, $this->storage);
    }

    public function get($key, $default = null)
    {
        return $this->storage[$key] ?? $default;
    }

    public function set($key, $value): self
    {
        $oldValue = $this->storage[$key] ?? null;
        $this->storage[$key] = $value;
        $this->fireChangeEvent(new StateManagerChangedEvent($key, 'set', $value, $oldValue));
        return $this;
    }

    public function remove($key): self
    {
        unset($this->storage[$key]);
        $this->fireChangeEvent(new StateManagerChangedEvent($key, 'remove'));
        return $this;
    }

    public function all(): array
    {
        return $this->storage;
    }

    public function addChangeListener(callable $listener)
    {
        $this->listeners[] = $listener;
    }

    /* Following 4 methods implement \ArrayAccess */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->remove($offset);
    }


    private function fireChangeEvent(StateManagerChangedEvent $event)
    {
        foreach($this->listeners as $l) if(!$event->isPropagationStopped()) $l($event);
    }
}