<?php
namespace recurringtasks;

interface TaskListRepository
{
    /**
     * @return TaskList
     */
    public function createTaskList();

    /**
     * @throws TaskListRepositoryException
     */
    public function commit();

    /**
     * @param TaskListId $id
     *
     * @return TaskList
     *
     * @throws TaskListRepositoryException
     */
    public function findById(TaskListId $id);
}