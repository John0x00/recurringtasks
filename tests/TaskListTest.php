<?php
namespace recurringtasks;

class TaskListTest extends \PHPUnit_Framework_TestCase
{
    public function testTaskListCanBeCreated()
    {
        $id = new TaskListId(new Uuid());
        $name = 'Test List';
        $taskList = new TaskList($id, $name);

        $this->assertInstanceOf(TaskList::class, $taskList);
        $this->assertEquals($name, $taskList->getName());
        $this->assertEquals($id, $taskList->getId());

        return $taskList;
    }

    /**
     * @depends testTaskListCanBeCreated
     */
    public function testTaskCanBeAddedToList(TaskList $taskList) {

        $task = new Task('test task 1');

        $taskList->addTask($task);
        $this->assertCount(1, $taskList->getTasks());
    }


    public function testTaskIsAddedInOrder() {

        $name = 'Test List';
        $taskList = new TaskList(new TaskListId(new Uuid()), $name);

        $task1 = new Task('Test Task 1');
        $task2 = new Task('Test Task 2');
        $taskList->addTask($task1);
        $taskList->addTask($task2);

        $tasks = $taskList->getTasks();

        $this->assertEquals($task1->getTitle(), $tasks[0]->getTitle());
        $this->assertEquals($task2->getTitle(), $tasks[1]->getTitle());

        return $taskList;
    }

    /**
     * @depends testTaskIsAddedInOrder
     */
    public function testTaskCompleteGoesToBottomOfList(TaskList $taskList) {

        $tasksBefore = $taskList->getTasks();

        $taskList->markTaskComplete($tasksBefore[0]);
        $tasksAfter = $taskList->getTasks();
        $this->assertEquals($tasksBefore[0], $tasksAfter[1]);


    }




}