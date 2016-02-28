<?php

namespace recurringtasks;


class TaskList
{

    /** @var Task[] */
    private $tasks = [];

    /**
     * TaskList constructor.
     * @param TaskListId $id
     * @param string $name
     */
    public function __construct(TaskListId $id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task) {

        $this->tasks[] = $task;
    }

    /**
     * @return Task[]
     */
    public function getTasks() {
        return $this->tasks;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }


    public function markTaskComplete(Task $task) {
        $tasks = [];
        foreach ($this->tasks as $k => $v) {
            if ($v == $task) {
                continue;
            }
            $tasks[] = $v;
        }
        $tasks[] = $task;
        $this->tasks = $tasks;
    }

}