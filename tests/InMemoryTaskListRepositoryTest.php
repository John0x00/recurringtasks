<?php
namespace recurringtasks;

class InMemoryTaskListRepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testTaskListCanBeCreated()
    {
        $repository = new InMemoryTaskListRepository();

        $taskList = $repository->createTaskList();

        $this->assertInstanceOf(TaskList::class, $taskList);
    }

    public function testScheduleCanBeFound()
    {
        $repository = new InMemoryTaskListRepository();

        $taskList = $repository->createTaskList();

        $this->assertSame(
            $taskList,
            $repository->findById($taskList->getId())
        );
    }

    public function testCannotFindScheduleThatDoesNotExist()
    {
        $repository = new InMemoryTaskListRepository();

        $this->expectException(TaskListNotFoundException::class);

        $repository->findById(new TaskListId(new Uuid));
    }

    public function testDoesNothingOnCommit()
    {
        $repository = new InMemoryTaskListRepository();

        $this->assertNull($repository->commit());
    }
}