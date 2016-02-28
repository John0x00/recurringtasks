<?php


namespace recurringtasks;


class SimpleTaskListRepository implements TaskListRepository
{
    /**
     * @var string
     */
    private $dataDirectory;

    /**
     * @var InMemoryTaskListRepository
     */
    private $repository;

    /**
     * @var taskList[]
     */
    private $taskLists = [];

    /**
     * @param string                     $dataDirectory
     * @param InMemoryTaskListRepository $repository
     */
    public function __construct($dataDirectory, InMemoryTaskListRepository $repository)
    {
        $this->dataDirectory = $dataDirectory;
        $this->repository    = $repository;
    }

    /**
     * @return TaskList
     */
    public function createTaskList()
    {
        $taskList = $this->repository->createTaskList();

        $this->taskLists[] = $taskList;

        return $taskList;
    }

    /**
     * @throws ScheduleRepositoryException
     */
    public function commit()
    {
        foreach ($this->taskLists as $taskList) {
            file_put_contents(
                sprintf(
                    '%s/%s',
                    $this->dataDirectory,
                    $taskList->getId()
                ),
                serialize($taskList)
            );
        }
    }

    /**
     * @param TaskListId $id
     *
     * @return TaskList
     *
     * @throws ScheduleRepositoryException
     */
    public function findById(TaskListId $id)
    {
        try {
            return $this->repository->findById($id);
        } catch (TaskListNotFoundException $e) {
            return $this->load($id);
        }
    }

    private function load(TaskListId $id)
    {
        $taskList = unserialize(
            @file_get_contents(
                sprintf(
                    '%s/%s',
                    $this->dataDirectory,
                    $id
                )
            )
        );

        if (!$taskList instanceof TaskList) {
            throw new TaskListNotFoundException;
        }

        return $taskList;
    }
}