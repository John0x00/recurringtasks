<?php
namespace recurringtasks;

class InMemoryTaskListRepository implements TaskListRepository
{
    /**
     * @var TaskList[]
     */
    private $taskList = [];

    /**
     * @return TaskList
     */
    public function createTaskList()
    {
        $id = new TaskListId(new Uuid);

        $taskList = new TaskList($id, 'New Task List');

        $this->taskList[] = $taskList;

        return $taskList;
    }

    public function commit()
    {
    }

    public function findById(TaskListId $id)
    {
        foreach ($this->taskList as $taskList) {
            if ($taskList->getId()->equals($id)) {
                return $taskList;
            }
        }

        throw new TaskListNotFoundException;
    }
}