<?php
namespace recurringtasks;

class TaskListId
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @param Uuid $uuid
     */
    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString()
    {
        return (string) $this->uuid;
    }

    public function equals(TaskListId $id)
    {
        if ((string) $this == (string) $id) {
            return true;
        }

        return false;
    }
}