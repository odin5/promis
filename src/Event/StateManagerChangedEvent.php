<?php
/**
 * Author: Mojmír Odehnal <mojmir.odehnal@centrum.cz>
 * Created: 23.08.2018 17:12
 */
namespace App\Event;


use Symfony\Component\EventDispatcher\Event;

class StateManagerChangedEvent extends Event
{
    private $key;
    private $action;
    private $newValue;
    private $oldValue;

    /**
     * StateManagerChangeEvent constructor.
     * @param $key string Key of state entry, that have changed
     * @param $action string Action, that happened on the entry (either 'set' or 'remove')
     * @param $newValue mixed If the action was 'set', contains the new value set to entry, otherwise null.
     * @param $value mixed If the action was 'set', contains the old value set to entry, otherwise null.
     */
    public function __construct(string $key, string $action, $newValue=null, $oldValue=null)
    {
        $this->key = $key;
        $this->action = $action;
        $this->newValue = $newValue;
        $this->oldValue = $oldValue;
    }

    /**
     * @return string Key of state entry, that have changed
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string Action, that happened on the entry (either 'set' or 'remove')
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return mixed If the action was 'set', the new value set to entry, otherwise null.
     */
    public function getNewValue()
    {
        return $this->newValue;
    }

    /**
     * @return mixed If the action was 'set', the old value set to entry, otherwise null.
     */
    public function getOldValue()
    {
        return $this->oldValue;
    }
}